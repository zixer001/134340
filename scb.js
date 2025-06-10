const axios = require("axios");
const loginConstant = require("./constants/login.constant");
const transConstant = require("../scb/constants/transaction.constant");
const { serviceError, handleError } = require("./helpers/error.helper");
const dayjs = require("dayjs");

/**========================================================== *
const deviceId = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
const pin = "xxxxxx";
const account = "4301171891";
/**========================================================== */
const urlScbEasy = "https://fasteasy.scbeasy.com";
const axiosInsLogin = axios.create({
    baseURL: "https://fasteasy.scbeasy.com:8443/v3",
    timeout: 60000,
    headers: {
        "Accept-Language": "th",
        "scb-channel": "APP",
        "user-agent": "Android/11;FastEasy/3.62.0/6573",
        "Content-Type": "application/json; charset=UTF-8",
        Host: "fasteasy.scbeasy.com:8443",
        Connection: "close",
    },
});

class Scb {
    constructor(deviceId, pin) {
        if (deviceId) this.deviceId = deviceId;
        if (pin) this.pin = pin;
    }
    loginScbPreloadAndResumeCheck() {
        const deviceId = this.deviceId;
        return axiosInsLogin
            .post("/login/preloadandresumecheck", {
                deviceId,
                jailbreak: "0",
                tilesVersion: "39",
                userMode: "INDIVIDUAL",
            })
            .then((response) => {
                const { code: resCode } = response.data.status;
                if (resCode === 1000) {
                    const { "api-auth": apiAuth } = response.headers;
                    return apiAuth;
                } else {
                    throw new Error(`code_${resCode}`);
                }
            })
            .catch((error) => {
                throw new serviceError(loginConstant[error.message]);
            });
    }

    loginScbPreAuth(apiAuth) {
        return axios
            .post(
                `${urlScbEasy}/isprint/soap/preAuth`, {
                loginModuleId: "PseudoFE",
            }, {
                headers: {
                    "Api-Auth": apiAuth,
                    "Content-Type": "application/json",
                },
            }
            )
            .then((response) => {
                const resData = response.data;
                const { statusdesc: statusDesc } = resData.status;
                if (statusDesc === "success") {
                    return {
                        hashType: resData.e2ee.pseudoOaepHashAlgo,
                        sId: resData.e2ee.pseudoSid,
                        serverRandom: resData.e2ee.pseudoRandom,
                        pubKey: resData.e2ee.pseudoPubKey,
                    };
                } else {
                    throw new Error();
                }
            })
            .catch((error) => {
                throw new serviceError(error);
            });
    }

    loginScbApiPin(preAuth, pin) {
        const params = new URLSearchParams();
        params.append("Sid", preAuth.sId);
        params.append("ServerRandom", preAuth.serverRandom);
        params.append("pubKey", preAuth.pubKey);
        params.append("hashType", preAuth.hashType);
        params.append("pin", pin);
        return axios
            .post("https://scb.mskids.me/pin/encrypt", params, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then((response) => {
                const resData = response.data;
                if (resData) {
                    return resData;
                } else {
                    throw new Error();
                }
            })
            .catch((error) => {
                throw new serviceError(error);
            });
    }

    loginScbFasteasy(pseudoPin, preAuth, apiAuth) {
        const params = new URLSearchParams();
        params.append("Sid", preAuth.sId);
        params.append("ServerRandom", preAuth.serverRandom);
        params.append("pubKey", preAuth.pubKey);
        params.append("hashType", preAuth.hashType);
        params.append("pin", this.pin);
        return axios
            .post(
                `${urlScbEasy}/v1/fasteasy-login`, {
                deviceId: this.deviceId,
                pseudoPin: pseudoPin,
                pseudoSid: preAuth.sId,
            }, {
                headers: {
                    "Api-Auth": apiAuth,
                    "user-agent": "Android/11;FastEasy/3.62.0/6573",
                    Host: "fasteasy.scbeasy.com",
                    "Content-Type": "application/json",
                },
            }
            )
            .then((response) => {
                const { code: resCode } = response.data.status;

                if (resCode === 1000) {
                    const { "api-auth": apiAuth } = response.headers;
                    return apiAuth;
                } else {
                    console.log(response.data);
                    throw new Error('code_1060');
                }
            })
            .catch((error) => {
                throw new serviceError(loginConstant[error.message]);
            });
    }

    async handleLoginScb() {
        try {
            const apiAuth = await this.loginScbPreloadAndResumeCheck();
            const preAuth = await this.loginScbPreAuth(apiAuth);
            const apiPin = await this.loginScbApiPin(preAuth, this.pin);
            const fastLogin = await this.loginScbFasteasy(apiPin, preAuth, apiAuth);
            return fastLogin;
        } catch (error) {
            console.log("handleLoginScb", error);
            return handleError(error);
        }
    }

    getTransaction = async (data) => {
        const dataObj = {
            accountNo: data.accountNo,
            startDate: data.startDate || dayjs().date(1).format(),
            endDate: data.endDate || dayjs().format(),
            pageNumber: data.pageNumber || 1,
            pageSize: data.pageSize || 20,
            productType: data.productType || "2",
        };
        const apiAuth = await this.handleLoginScb();
        return axios
            .post(`${urlScbEasy}/v2/deposits/casa/transactions`, dataObj, {
                headers: {
                    "Api-Auth": apiAuth,
                    "Accept-Language": "th",
                    "Content-Type": "application/json; charset=UTF-8",
                },
            })
            .then((response) => {
                const data = response.data;
                const { code: resCode } = data.status;
                if (resCode === 1000) {
                    return data.data;
                } else {
                    throw new Error(`code_${resCode}`);
                }
            })
            .catch((error) => {
                return handleError(new serviceError(transConstant[error.message]));
            });
    };

    getQRCode = async (data) => {
        const dataObj = {
            barcode: data.qrcode,
            tilesVersion: '41',
        };
        const apiAuth = await this.handleLoginScb();
        return axios
            .post(`${urlScbEasy}/v7/payments/bill/scan`, dataObj, {
                headers: {
                    "Api-Auth": apiAuth,
                    "Accept-Language": "th",
                    "Content-Type": "application/json; charset=UTF-8",
                },
            })
            .then((response) => {
                const data = response.data;
                const { code: resCode } = data.status;
                if (resCode === 1000) {
                    return data;
                } else {
                    throw new Error(`code_${resCode}`);
                }
            })
            .catch((error) => {
                return handleError(new serviceError(transConstant[error.message]));
            });
    };


    withdrawTransfer = async (data) => {

        const dataObj = {
            accountFrom: data.accountTo,
            accountFromName: data.accountFromName,
            accountFromType: 2,
            accountTo: data.accountTo,
            accountToBankCode: data.accountToBankCode,
            accountToName: data.accountToName,
            amount: data.amount,
            botFee: 0.0,
            channelFee: 0.0,
            fee: 0.0,
            feeType: '',
            pccTraceNo: data.pccTraceNo,
            scbFee: 0.0,
            sequence: data.sequence,
            terminalNo: data.terminalNo,
            transactionToken: data.transactionToken,
            transferType: data.transferType,
        };
        const apiAuth = await this.handleLoginScb();
        return axios
            .post(`${urlScbEasy}/v3/transfer/confirmation`, dataObj, {
                headers: {
                    "Api-Auth": apiAuth,
                    "Accept-Language": "th",
                    "Content-Type": "application/json; charset=UTF-8",
                },
            })
            .then((response) => {
                const data = response.data;
                const { code: resCode } = data.status;
                if (resCode === 1000) {
                    return data.data;
                } else {
                    throw new Error(`code_${resCode}`);
                }
            })
            .catch((error) => {
                return handleError(new serviceError(transConstant[error.message]));
            });
    };
    verify = async (data) => {

        let transferType = '';
        if (data.accountToBankCode == "014") {
            transferType = "3RD";
        } else {
            transferType = "ORFT";
        }
        const dataObj = {
            accountFrom: data.accnum,
            accountFromType: 2,
            accountTo: data.accountTo,
            accountToBankCode: data.accountToBankCode,
            amount: data.amount,
            annotation: null,
            transferType: transferType,
        };
        const apiAuth = await this.handleLoginScb();
        return axios
            .post(`${urlScbEasy}/v2/transfer/verification`, dataObj, {
                headers: {
                    "Api-Auth": apiAuth,
                    "Accept-Language": "th",
                    "Content-Type": "application/json; charset=UTF-8",
                },
            })
            .then((response) => {
                const data = response.data;
                const { code: resCode } = data.status;
                if (resCode === 1000) {
                    return data.data;
                } else {
                    throw new Error(`code_${resCode}`);
                }
            })
            .catch((error) => {
                return handleError(new serviceError(transConstant[error.message]));
            });
    };

    checkBalance = async (data) => {
        const dataObj = {
            depositList: [{
                accountNo: data.accountNo
            }],
            numberRecentTxn: 2,
            tilesVersion: 39,
        };
        const apiAuth = await this.handleLoginScb();
        return axios
            .post(`${urlScbEasy}/v2/deposits/summary`, dataObj, {
                headers: {
                    "Api-Auth": apiAuth,
                    "Accept-Language": "th",
                    "Content-Type": "application/json; charset=UTF-8",
                },
            })
            .then((response) => {
                const data = response.data;
                const { code: resCode } = data.status;
                if (resCode === 1000) {
                    return data.totalAvailableBalance;
                } else {
                    throw new Error(`code_${resCode}`);
                }
            })
            .catch((error) => {
                return handleError(new serviceError(transConstant[error.message]));
            });
    };

}

module.exports = Scb;