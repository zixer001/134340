const model = require("../models/utility.model");
const httpCode = require("../../constants/httpStatusCodes");

module.exports.testSQL = async (token) => {
    const sql =
        "SELECT LOWER(CONVERT(ssssss USING utf8)) AS url_pic FROM test_sql";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("testSQL have error :", error);
    }
};

module.exports.accountBank = async () => {
    const sql = `SELECT
                    *
                FROM
                account_bank aw WHERE aw.type='scb' AND aw.sts = 1
                LIMIT 1  
               `;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("accountBank have error :", error);
    }
};

module.exports.InsertDataToFinanceWithdraw = async (data) => {
    const sql = `INSERT INTO finance_withdraw(id, qrcode, functions, amount, transref, sender_name, sender_accounttype, sender_accountnumber, sender_banklogo, receiver_banklogo, receiver_name, receiver_accounttype, receiver_accountnumber, receiver_proxytype, receiver_proxynumber, ref1, ref2, ref3, datetime, cr_by, cr_date,host_name,reply,uid,token,sts) VALUES (null,'${data.qrcode}','${data.function}','${data.amount}','${data.transRef}','${data.sender_name}','${data.sender_accountType}','${data.sender_accountNumber}','${data.sender_banklogo}','${data.receiver_banklogo}','${data.receiver_name}','${data.receiver_accountType}','${data.receiver_accountNumber}','${data.receiver_proxyType}','${data.receiver_proxyNumber}','${data.ref1}','${data.ref2}','${data.ref3}','${data.dateTime}','${data.cr_by}','${data.cr_date}','${data.host_name}','${data.reply}','${data.uid}','${data.token}','${data.sts}')`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("InsertDataToFinanceWithdraw have error :", error);
    }
};

module.exports.InsertDataToFinanceDeposit = async (data) => {
    const sql = `INSERT INTO finance_deposit(id, qrcode, functions, amount, transref, sender_name, sender_accounttype, sender_accountnumber, sender_banklogo, receiver_banklogo, receiver_name, receiver_accounttype, receiver_accountnumber, receiver_proxytype, receiver_proxynumber, ref1, ref2, ref3, datetime, cr_by, cr_date,host_name,reply,uid,token,sts) VALUES (null,'${data.qrcode}','${data.function}','${data.amount}','${data.transRef}','${data.sender_name}','${data.sender_accountType}','${data.sender_accountNumber}','${data.sender_banklogo}','${data.receiver_banklogo}','${data.receiver_name}','${data.receiver_accountType}','${data.receiver_accountNumber}','${data.receiver_proxyType}','${data.receiver_proxyNumber}','${data.ref1}','${data.ref2}','${data.ref3}','${data.dateTime}','${data.cr_by}','${data.cr_date}','${data.host_name}','${data.reply}','${data.uid}','${data.token}','${data.sts}')`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("InsertDataToFinanceDeposit have error :", error);
    }
};

module.exports.queryTransrefDeposit = async (data) => {
    const sql =
        "SELECT * FROM finance_deposit WHERE transref = '" + data.transRef + "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryTransrefDeposit have error :", error);
    }
};

module.exports.queryTransrefWithdraw = async (data) => {
    const sql =
        "SELECT * FROM finance_withdraw WHERE transref = '" + data.transRef + "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryTransrefWithdraw have error :", error);
    }
};

module.exports.insertLog = async (data) => {
    const sql = `INSERT INTO logs(id,module,detail,cr_date,cr_by,token) VALUES(null,'${data.module}','${data.detail}','${data.cr_date}','${data.cr_by}','${data.token}')`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertLog have error :", error);
    }
};

module.exports.InsertQueueGenerator = async (data) => {
    const sql = `INSERT INTO queue_generator(id, qrcode, cr_by, cr_date,host_name,reply,uid,token,sts) VALUES (null,'${data.qrcode}','${data.cr_by}','${data.cr_date}','${data.host_name}','${data.reply}','${data.uid}','${data.token}',0)`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("InsertQueueGenerator have error :", error);
    }
};

module.exports.queryCheckQRCodeDeposit = async (data) => {
    const sql =
        "SELECT * FROM finance_deposit WHERE qrcode = '" +
        data +
        "' AND (sts = 1 OR sts = 0 OR sts = 3) AND qrcode != 0";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryCheckQRCodeDeposit have error :", error);
    }
};
module.exports.queryCheckQRCodeWithdraw = async (data) => {
    const sql =
        "SELECT * FROM finance_withdraw WHERE qrcode = '" +
        data +
        "'  AND (sts = 1 OR sts = 0 OR sts = 3)";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryCheckQRCodeWithdraw have error :", error);
    }
};

module.exports.queryCheckQueue = async (data) => {
    const sql = "SELECT * FROM queue_generator WHERE sts = " + data;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryCheckQueue have error :", error);
    }
};

module.exports.queryCheckQueueConJrob = async () => {
    const sql = "SELECT * FROM finance_deposit WHERE sts = 3 ORDER BY datetime";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryCheckQueueConJrob have error :", error);
    }
};

module.exports.checkAdminByUID = async (uid, token) => {
    const sql =
        "SELECT * FROM admin_member WHERE uid = '" +
        uid +
        "' AND token = '" +
        token +
        "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("checkAdminByUID have error :", error);
    }
};

module.exports.updateStatusFinanceDeoposit = async (id, sts, date) => {
    const sql = "UPDATE finance_deposit SET sts = " + sts + ",datetime = '" + date + "' WHERE id = " + id;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("updateStatusFinanceDeoposit have error :", error);
    }
};

module.exports.queryAccountNochkAdmin = async (acc, bank, token) => {
    let accsp = acc;
    let result;
    console.log(accsp);
    accsp = accsp.split('-');
    for (let i = 0; i < accsp.length; i++) {
        result += accsp[i];
    }
    acc = result.substring(result.length - 3, result.length);
    console.log(acc);
    const sql =
        "SELECT * FROM account_receive WHERE accountNo LIKE '%" +
        acc +
        "' AND bank = '" +
        bank +
        "' AND token = '" +
        token +
        "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryAccountNochkAdmin have error :", error);
    }
};

module.exports.queryDataLogin = async (req) => {
    const sql =
        "SELECT * FROM admin WHERE username = '" +
        req.body.username +
        "' AND password = '" +
        req.body.password +
        "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryDataLogin have error :", error);
    }
};

module.exports.queryRegister = async (req) => {
    const sql =
        "SELECT * FROM admin WHERE username = '" +
        req.body.username +
        "' AND email = '" +
        req.body.email +
        "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryRegister have error :", error);
    }
};

module.exports.insertTokenTodatabase = async (req) => {
    const sql =
        "INSERT INTO log_token (id,token,ip_address) VALUES (null, '" +
        req.token +
        "','" +
        req.ip +
        "')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertTokenTodatabase have error :", error);
    }
};

module.exports.queryAllStaffByID = async (req) => {
    const sql = "SELECT * FROM admin  WHERE id = " + req.body.id;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryAllStaffByID have error :", error);
    }
};

module.exports.queryMenuLv1 = async () => {
    const sql = `SELECT * FROM tb_menu WHERE lv_menu = 'lv1'   AND sts = 1 ORDER BY order_id asc`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryMenuLv1 have error :", error);
    }
};

module.exports.queryMenuParent_lv1 = async (GameSetting) => {
    const sql = `SELECT * FROM tb_menu WHERE lv_menu = 'lv2' AND parent_lv1 = ${GameSetting.parent_lv1} AND sts = 1  ORDER BY order_id asc`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryMenuParent_lv1 have error :", error);
    }
};

module.exports.insertMemberInDatabase = async (data) => {
    const sql =
        "INSERT INTO admin (id,email,name,username,password,password_old,stats,category,secert_code,mapping_auth_api) VALUES (null, '" +
        data.email +
        "','" +
        data.name +
        "','" +
        data.username +
        "','" +
        data.password +
        "','" +
        data.password_old +
        "','" +
        data.stats +
        "','" +
        data.category +
        "','" +
        data.secert_code +
        "','" +
        data.mapping_auth_api +
        "')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertMemberInDatabase have error :", error);
    }
};

module.exports.queryLogToken = async (token) => {
    const sql = "SELECT * FROM log_token WHERE token = '" + token + "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryLogToken have error :", error);
    }
};

module.exports.queryStatsDeposit = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT SUM(amount) AS balance FROM finance_deposit WHERE token = '" +
        data.token +
        "' AND sts = 1" + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryStatsDeposit have error :", error);
    }
};

module.exports.queryStatsWithdraw = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT SUM(amount) AS balance FROM finance_withdraw WHERE token = '" +
        data.token +
        "' AND sts = 1 " + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryStatsWithdraw have error :", error);
    }
};

module.exports.deleteLogToken = async (id) => {
    const sql = "DELETE FROM log_token WHERE id = " + id;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("deleteLogToken have error :", error);
    }
};

module.exports.queryProductList = async (data) => {
    const sql =
        "SELECT product_service.id AS id,product_service.product_token AS product_token,product_service.product_name AS product_name , promotion.promotion_name AS promotion_name , product_service.cr_date AS cr_date, history_promotion.cr_exp AS cr_exp FROM product_service INNER JOIN history_promotion ON history_promotion.id = product_service.history_id INNER JOIN promotion ON promotion.id = history_promotion.promotion_id  WHERE product_service.member_id = " +
        data;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryProductList have error :", error);
    }
};

module.exports.queryProductListAll = async () => {
    const sql =
        "SELECT admin.username AS username,product_service.id AS id,product_service.product_token AS product_token,product_service.product_name AS product_name , promotion.promotion_name AS promotion_name , product_service.cr_date AS cr_date, history_promotion.cr_exp AS cr_exp FROM product_service INNER JOIN history_promotion ON history_promotion.id = product_service.history_id INNER JOIN promotion ON promotion.id = history_promotion.promotion_id INNER JOIN admin ON admin.id = product_service.member_id ORDER BY history_promotion.id DESC";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryProductListAll have error :", error);
    }
};


module.exports.queryDetailProductEXP = async (data) => {
    const sql =
        "SELECT * FROM product_service INNER JOIN history_promotion ON history_promotion.product_id = product_service.id WHERE product_service.product_token = '" +
        data.token +
        "' ORDER BY history_promotion.id DESC LIMIT 1";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryDetailProductEXP have error :", error);
    }
};
module.exports.queryLimitSlipPromotion = async (data) => {

    // const sql =
    //     "SELECT * FROM product_service WHERE product_service.product_token = '" +
    //     data.token +
    //     "'";
    const sql =  `SELECT promotion.limit_slip AS limit_slip FROM product_service INNER JOIN history_promotion ON history_promotion.id = product_service.history_id INNER JOIN promotion ON promotion.id = history_promotion.promotion_id WHERE product_service.product_token = '${data.token}'`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryLimitSlipPromotion have error :", error);
    }
};

module.exports.queryStatsSlipDashboard = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT * FROM finance_deposit WHERE token = '" + data.token + "' "+RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryStatsSlipDashboard have error :", error);
    }
};

module.exports.queryStatsSlip = async (data) => {
    const sql =
        "SELECT * FROM finance_deposit WHERE token = '" + data.token + "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryStatsSlip have error :", error);
    }
};

module.exports.queryStatsSlipPackage = async (data) => {
    const sql =
        "SELECT * FROM finance_deposit WHERE token = '" + data.token + "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryStatsSlip have error :", error);
    }
};

module.exports.queryDepositAll = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT SUM(amount) AS amount FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "' AND sts = 1" +
        RESULT;

    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryDepositAll have error :", error);
    }
};

module.exports.queryLimitAmount = async (data) => {
    const sql =
        "SELECT * FROM product_service WHERE product_token = '" + data.token + "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryLimitAmount have error :", error);
    }
};

module.exports.queryMinAmount = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT * FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "'" +
        RESULT +
        "  AND sts = 1 ORDER BY amount ASC";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryMinAmount have error :", error);
    }
};

module.exports.queryAmountNoToday = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date NOT LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date NOT LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date NOT LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT SUM(amount) AS balance FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "' AND sts = 1 " + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryAmountNoToday have error :", error);
    }
};

module.exports.querySlipAll = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT * FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "' AND sts = 1" + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySlipAll have error :", error);
    }
};

module.exports.querySlipLimitAmount = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT * FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "' AND sts = 1 AND amount <= " +
        data.limit_amount + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySlipLimitAmount have error :", error);
    }
};

module.exports.querySlipNoToday = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT * FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "' AND sts = 1 " + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySlipNoToday have error :", error);
    }
};

module.exports.querySlipEXP = async (data) => {
    let RESULT = '';
    if (data.type == 'Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'Last Month') {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    } else if (data.type == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql =
        "SELECT * FROM " +
        data.schme +
        " WHERE token = '" +
        data.token +
        "' AND (sts = 0 OR sts = 2) " + RESULT;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySlipEXP have error :", error);
    }
};


module.exports.querySettingNormal = async (data) => {
    const sql =
        "SELECT product_service.id AS id,product_service.product_name AS product_name,product_service.product_token AS product_token,promotion.promotion_name AS promotion_name,promotion.limit_slip AS limit_slip,promotion.price AS price FROM product_service INNER JOIN history_promotion ON history_promotion.id = product_service.history_id INNER JOIN promotion ON promotion.id = history_promotion.promotion_id  WHERE product_service.id = '" +
        data +
        "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySettingNormal have error :", error);
    }
};

module.exports.querySettingSystem = async (data) => {
    const sql =
        "SELECT *,account_receive.id AS aid FROM product_service LEFT JOIN account_receive ON account_receive.token = product_service.product_token LEFT JOIN token_userline ON token_userline.token = product_service.product_token WHERE product_service.product_token = '" +
        data.token +
        "'";
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySettingSystem have error :", error);
    }
};


module.exports.editSettingSystem = async (data) => {
    const sql = `UPDATE product_service SET limit_amount = '${data.limit_amount}',token_notify= '${data.token_notify}' WHERE product_token = '${data.token}'`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("editSettingSystem have error :", error);
    }
};
module.exports.editSettingSystemBank = async (data) => {
    const sql = `UPDATE account_receive SET accountNo = '${data.accountNo}', bank = '${data.bank}', name = '${data.name}'  WHERE id = '${data.id}'`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("editSettingSystemBank have error :", error);
    }
};
module.exports.editSettingSystemLine = async (data) => {
    const sql = `UPDATE token_userline SET line_token = '${data.line_token}'  WHERE token = '${data.token}'`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("editSettingSystemLine have error :", error);
    }
};


module.exports.insertBank = async (data) => {
    const sql =
        "INSERT INTO account_receive (id,accountNo,name,bank,token,cr_by,cr_date,product_id) VALUES (null, '" +
        data.accountNo +
        "','" +
        data.name +
        "','" +
        data.bank +
        "','" +
        data.token +
        "','" +
        data.cr_by +
        "','" +
        data.cr_date +
        "','" +
        data.product_id +
        "')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertMemberInDatabase have error :", error);
    }
};


module.exports.insertTokenLine = async (data) => {
    const sql =
        "INSERT INTO token_userline (id,line_token,token,sts) VALUES (null, '" +
        data.line_token +
        "','" +
        data.token +
        "','1')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertMemberInDatabase have error :", error);
    }
};


module.exports.insertProductService = async (data) => {
    const sql =
        "INSERT INTO product_service (id,product_name,product_token,member_id,history_id,limit_slip,cr_date,limit_amount) VALUES (null, '" +
        data.product_name +
        "','" +
        data.product_token +
        "','" +
        data.member_id +
        "','" +
        data.history_id +
        "','" +
        data.limit_slip +
        "','" +
        data.cr_date +
        "','" +
        data.limit_amount +
        "')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertProductService have error :", error);
    }
};


module.exports.insertHistoryPromotion = async (data) => {
    const sql =
        "INSERT INTO history_promotion (id,member_id,product_id,promotion_id,cr_date,cr_exp) VALUES (null, '" +
        data.member_id +
        "','" +
        data.product_id +
        "','" +
        data.promotion_id +
        "','" +
        data.cr_date +
        "','" +
        data.cr_exp +
        "')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("insertHistoryPromotion have error :", error);
    }
};

module.exports.UpdatePromotionInUser = async (data) => {
    const sql =
        "UPDATE product_service SET history_id  = " + data.hisID + ", limit_slip = " + data.limit_slip + " WHERE id = " + data.id;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("UpdatePromotionInUser have error :", error);
    }
};

module.exports.InsertAdminUID = async (data) => {
    const sql =
        "INSERT INTO admin_member (id,uid,token,cr_date,cr_by) VALUES (null, '" +
        data.uid +
        "','" +
        data.token +
        "','" +
        data.cr_date +
        "','" +
        data.username +
        "')";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("InsertAdminUID have error :", error);
    }
};

module.exports.editSettingNormal = async (data) => {
    const sql =
        "UPDATE product_service SET product_name  = '" + data.name + "' WHERE id = " + data.id;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("editSettingNormal have error :", error);
    }
};

module.exports.updateFinanceDeposit = async (data) => {
    const sql = `UPDATE finance_deposit SET functions = '${data.function}',amount = '${data.amount}',dateTime = '${data.dateTime}',transRef = '${data.transRef}', sender_name = '${data.sender_name}',sender_accountType = '${data.sender_accountType}',sender_accountNumber = '${data.sender_accountNumber}',sender_banklogo = '${data.sender_banklogo}', receiver_banklogo = '${data.receiver_banklogo}',receiver_name = '${data.receiver_name}',receiver_accountType = '${data.receiver_accountType}',receiver_accountNumber = '${data.receiver_accountNumber}', receiver_proxyType = '${data.receiver_proxyType}',receiver_proxyNumber = '${data.receiver_proxyNumber}',ref1 = '${data.ref1}',ref2 = '${data.ref2}',ref3 = '${data.ref3}', sts = '${data.sts}' WHERE id = '${data.id}'`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("updateFinanceDeposit have error :", error);
    }
};



module.exports.queryChartDeposit = async (data) => {
    let RESULT = '';
    if (data.date == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql = `SELECT HOUR(cr_date) AS hour, SUM(amount) AS amount
    FROM finance_deposit WHERE token = '${data.token}'${RESULT} AND sts = 1
    GROUP BY hour(cr_date) ORDER BY hour`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryChartDeposit have error :", error);
    }
};

module.exports.queryChartDepositMonth = async (data) => {
    const sql = `SELECT day(cr_date) AS day, SUM(amount) AS amount
    FROM finance_deposit WHERE cr_date LIKE '${data.date}%' AND token = '${data.token}'  AND sts = 1
    GROUP BY day(cr_date)  ORDER BY cr_date `;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryChartDepositMonth have error :", error);
    }
};

module.exports.queryChartWithdraw = async (data) => {
    let RESULT = '';
    if (data.date == 'All') {
        RESULT = "";
    } else {
        RESULT = " AND cr_date LIKE '" + data.date + "%'";
    }
    const sql = `SELECT HOUR(cr_date) AS hour, SUM(amount) AS amount
    FROM finance_withdraw WHERE token = '${data.token}'${RESULT} AND sts = 1
    GROUP BY hour(cr_date) , day(cr_date) ORDER BY hour`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryChartWithdraw have error :", error);
    }
};

module.exports.queryChartWithdrawMonth = async (data) => {
    const sql = `SELECT day(cr_date) AS day, SUM(amount) AS amount
    FROM finance_withdraw WHERE cr_date LIKE '${data.date}%' AND token = '${data.token}' AND sts = 1
    GROUP BY day(cr_date) , day(cr_date) ORDER BY cr_date`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryChartWithdraw have error :", error);
    }
};


module.exports.getPromotion = async () => {
    const sql = `SELECT * FROM promotion`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("getPromotion have error :", error);
    }
};

module.exports.getPromotionByID = async (req) => {
    const sql = `SELECT * FROM promotion WHERE id = ${req.body.promotion_id}`;
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("getPromotionByID have error :", error);
    }
};

module.exports.updateStsTokenLine = async (data) => {
    const sql = `UPDATE token_userline SET sts = '0'  WHERE token = '${data.token}'`;
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("updateStsTokenLine have error :", error);
    }
};


module.exports.queryPromotion = async (req) => {
    const sql = "SELECT * FROM promotion  WHERE sts = 1"
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryPromotion have error :", error);
    }
};

module.exports.getMemberByProductID = async (req) => {
    const sql = "SELECT * FROM product_service  WHERE id = " + req.body.product_id
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("getMemberByProductID have error :", error);
    }
};

module.exports.UpdateTokenLineSts = async (data) => {
    const sql =
        "UPDATE token_userline SET sts  = 1 WHERE token = '" + data + "'";
    try {
        const result = await model.insertOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("UpdateTokenLineSts have error :", error);
    }
};

module.exports.queryDateOfPackage = async (req) => {
    const sql = "SELECT history_promotion.id,history_promotion.cr_date FROM product_service INNER JOIN history_promotion ON history_promotion.id = product_service.history_id  WHERE product_service.product_token = '" + req.product_token+"'"
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryDateOfPackage have error :", error);
    }
};

module.exports.querySlipFromPackage = async (data) => {
    const sql = `SELECT * FROM finance_deposit  WHERE token = '${data.token}' AND cr_date >= '${data.date}'`
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("querySlipFromPackage have error :", error);
    }
};

module.exports.queryNameProduct = async (data) => {
    const sql = `SELECT product_name FROM product_service  WHERE product_token = '${data.product_token}'`
    try {
        const result = await model.queryOne(sql);
        return {
            status: true,
            statusCode: httpCode.Success.ok.codeText,
            result: result,
        };
    } catch (error) {
        console.log("queryNameProduct have error :", error);
    }
};


