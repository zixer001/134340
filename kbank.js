const axios = require("axios");
const dayjs = require("dayjs");
const fs = require("fs");
const { body, validationResult, param, check } = require("express-validator");
const { forEach } = require("lodash/collection");
const multer = require("multer");
const Jimp = require("jimp");
const jsQr = require("jsqr");
const Session = require("./src/session");
const config = require("./config");
const dataJson = require("./data.json");

let session;

class Kbank {
  constructor() {
    const state = dataJson;
    session = new Session(
      state,
      config.accountNo,
      config.accountType,
      config.pin
    );
    session.on("STATE_UPDATED", async (state) => {
      await fs.promises.writeFile("data.json", JSON.stringify(state, null, 4));
    });
  }

  balance = async () => {
    try {
      let result = await session.call((client) => {
        return client.getInquiryAccountBalance(
          session.accountNumber,
          session.accountType
        );
      });
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };

  activities = async () => {
    try {
      let result = await session.call(async (client) => {
        const response = await client.getAccountActivityList(session.accountNumber);

        forEach(response['activityList'] ?? [], activity => {
          session._activityList[activity['rqUid']] = activity;
        });
        return response;
      });
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };
  activitiesDetail = async (params) => {
    try {
      const activity = session._activityList[params];
      let result = await session.call((client) => {
        return client.getAccountActivityDetail(session.accountNumber, activity);
      });
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };

  bankInfoList = async (params) => {
    try {
      let result = await session.getBankInfoList();
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };
  inquireForTransferMoney = async (params) => {
    try {
      let bankInfo = await session.getBankInfoList();
      bankInfo = bankInfo[params.toBankCode];
      let result = await session.call(async (client) => {
        const handle = {};
        const response = await client.inquireForTransferMoney(handle, session.accountNumber, params.toAccount, params.amount, bankInfo['transferType'], bankInfo['targetBankCode'],);

        session._inquireForTransferMoneyList[response['kbankInternalSessionId']] = handle;
        return response;
      });
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };

  transferMoney = async (params) => {
    try {
      let result = await session.call(async (client) => {
        const handle = session._inquireForTransferMoneyList[params.kbankInternalSessionId];

        return client.transferMoney(handle);
      });
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };

  ScanQRCode = async (data) => {
    try {
      let result = await session.call(async (client) => {
        return client.scanQr(data);
      });
      return result;
    } catch (e) {
      return { error: e.message };
    }
  };
}

module.exports = Kbank;
