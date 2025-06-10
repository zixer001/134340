const queryMember = require("../functions/qdmbackend");
const stt = require("../../constants/statusText");
let request = require("request");
const jwt = require("jsonwebtoken");
const httpStatusCodes = require("../../constants/httpStatusCodes");
const truewallet = require("../library/truewalletVoucher");
const axios = require("axios");
var qs = require("qs");
const scb = require("../library/scb/scb");
const kbank = require("../library/kbank/kbank");
const multer = require("multer");
const Jimp = require("jimp");
const jsQr = require("jsqr");
var CronJob = require("cron").CronJob;
const kbankObj = new kbank();
const logs = require('../functions/logs');
const util = require('util');
const exec = util.promisify(require('child_process').exec);

// ###########################  Unity Function #########################################
function aes256(password) {
    return new Promise((resolve, reject) => {
        let genpw = password;
        let fp1 = genpw;
        let key = "aPjr2QDDfjmb72Vs";
        let cipher = crypto.createCipher("aes256", key);
        let fp2 = cipher.update(fp1, "base64", "base64") + cipher.final("base64");
        resolve({ genpw: genpw, fp2: fp2 });
    });
}

function formatMoney(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}
var GenPass = function (d) {
    var r = M(V(Y(X(d), 8 * d.length)));
    return r.toLowerCase();
};

function M(d) {
    for (var _, m = "0123456789ABCDEF", f = "", r = 0; r < d.length; r++)
        (_ = d.charCodeAt(r)), (f += m.charAt((_ >>> 4) & 15) + m.charAt(15 & _));
    return f;
}

function X(d) {
    for (var _ = Array(d.length >> 2), m = 0; m < _.length; m++) _[m] = 0;
    for (m = 0; m < 8 * d.length; m += 8)
        _[m >> 5] |= (255 & d.charCodeAt(m / 8)) << m % 32;
    return _;
}

function V(d) {
    for (var _ = "", m = 0; m < 32 * d.length; m += 8)
        _ += String.fromCharCode((d[m >> 5] >>> m % 32) & 255);
    return _;
}

function Y(d, _) {
    (d[_ >> 5] |= 128 << _ % 32), (d[14 + (((_ + 64) >>> 9) << 4)] = _);
    for (
        var m = 1732584193, f = -271733879, r = -1732584194, i = 271733878, n = 0; n < d.length; n += 16
    ) {
        var h = m,
            t = f,
            g = r,
            e = i;
        (f = md5_ii(
            (f = md5_ii(
                (f = md5_ii(
                    (f = md5_ii(
                        (f = md5_hh(
                            (f = md5_hh(
                                (f = md5_hh(
                                    (f = md5_hh(
                                        (f = md5_gg(
                                            (f = md5_gg(
                                                (f = md5_gg(
                                                    (f = md5_gg(
                                                        (f = md5_ff(
                                                            (f = md5_ff(
                                                                (f = md5_ff(
                                                                    (f = md5_ff(
                                                                        f,
                                                                        (r = md5_ff(
                                                                            r,
                                                                            (i = md5_ff(
                                                                                i,
                                                                                (m = md5_ff(
                                                                                    m,
                                                                                    f,
                                                                                    r,
                                                                                    i,
                                                                                    d[n + 0],
                                                                                    7, -680876936
                                                                                )),
                                                                                f,
                                                                                r,
                                                                                d[n + 1],
                                                                                12, -389564586
                                                                            )),
                                                                            m,
                                                                            f,
                                                                            d[n + 2],
                                                                            17,
                                                                            606105819
                                                                        )),
                                                                        i,
                                                                        m,
                                                                        d[n + 3],
                                                                        22, -1044525330
                                                                    )),
                                                                    (r = md5_ff(
                                                                        r,
                                                                        (i = md5_ff(
                                                                            i,
                                                                            (m = md5_ff(
                                                                                m,
                                                                                f,
                                                                                r,
                                                                                i,
                                                                                d[n + 4],
                                                                                7, -176418897
                                                                            )),
                                                                            f,
                                                                            r,
                                                                            d[n + 5],
                                                                            12,
                                                                            1200080426
                                                                        )),
                                                                        m,
                                                                        f,
                                                                        d[n + 6],
                                                                        17, -1473231341
                                                                    )),
                                                                    i,
                                                                    m,
                                                                    d[n + 7],
                                                                    22, -45705983
                                                                )),
                                                                (r = md5_ff(
                                                                    r,
                                                                    (i = md5_ff(
                                                                        i,
                                                                        (m = md5_ff(
                                                                            m,
                                                                            f,
                                                                            r,
                                                                            i,
                                                                            d[n + 8],
                                                                            7,
                                                                            1770035416
                                                                        )),
                                                                        f,
                                                                        r,
                                                                        d[n + 9],
                                                                        12, -1958414417
                                                                    )),
                                                                    m,
                                                                    f,
                                                                    d[n + 10],
                                                                    17, -42063
                                                                )),
                                                                i,
                                                                m,
                                                                d[n + 11],
                                                                22, -1990404162
                                                            )),
                                                            (r = md5_ff(
                                                                r,
                                                                (i = md5_ff(
                                                                    i,
                                                                    (m = md5_ff(
                                                                        m,
                                                                        f,
                                                                        r,
                                                                        i,
                                                                        d[n + 12],
                                                                        7,
                                                                        1804603682
                                                                    )),
                                                                    f,
                                                                    r,
                                                                    d[n + 13],
                                                                    12, -40341101
                                                                )),
                                                                m,
                                                                f,
                                                                d[n + 14],
                                                                17, -1502002290
                                                            )),
                                                            i,
                                                            m,
                                                            d[n + 15],
                                                            22,
                                                            1236535329
                                                        )),
                                                        (r = md5_gg(
                                                            r,
                                                            (i = md5_gg(
                                                                i,
                                                                (m = md5_gg(
                                                                    m,
                                                                    f,
                                                                    r,
                                                                    i,
                                                                    d[n + 1],
                                                                    5, -165796510
                                                                )),
                                                                f,
                                                                r,
                                                                d[n + 6],
                                                                9, -1069501632
                                                            )),
                                                            m,
                                                            f,
                                                            d[n + 11],
                                                            14,
                                                            643717713
                                                        )),
                                                        i,
                                                        m,
                                                        d[n + 0],
                                                        20, -373897302
                                                    )),
                                                    (r = md5_gg(
                                                        r,
                                                        (i = md5_gg(
                                                            i,
                                                            (m = md5_gg(m, f, r, i, d[n + 5], 5, -701558691)),
                                                            f,
                                                            r,
                                                            d[n + 10],
                                                            9,
                                                            38016083
                                                        )),
                                                        m,
                                                        f,
                                                        d[n + 15],
                                                        14, -660478335
                                                    )),
                                                    i,
                                                    m,
                                                    d[n + 4],
                                                    20, -405537848
                                                )),
                                                (r = md5_gg(
                                                    r,
                                                    (i = md5_gg(
                                                        i,
                                                        (m = md5_gg(m, f, r, i, d[n + 9], 5, 568446438)),
                                                        f,
                                                        r,
                                                        d[n + 14],
                                                        9, -1019803690
                                                    )),
                                                    m,
                                                    f,
                                                    d[n + 3],
                                                    14, -187363961
                                                )),
                                                i,
                                                m,
                                                d[n + 8],
                                                20,
                                                1163531501
                                            )),
                                            (r = md5_gg(
                                                r,
                                                (i = md5_gg(
                                                    i,
                                                    (m = md5_gg(m, f, r, i, d[n + 13], 5, -1444681467)),
                                                    f,
                                                    r,
                                                    d[n + 2],
                                                    9, -51403784
                                                )),
                                                m,
                                                f,
                                                d[n + 7],
                                                14,
                                                1735328473
                                            )),
                                            i,
                                            m,
                                            d[n + 12],
                                            20, -1926607734
                                        )),
                                        (r = md5_hh(
                                            r,
                                            (i = md5_hh(
                                                i,
                                                (m = md5_hh(m, f, r, i, d[n + 5], 4, -378558)),
                                                f,
                                                r,
                                                d[n + 8],
                                                11, -2022574463
                                            )),
                                            m,
                                            f,
                                            d[n + 11],
                                            16,
                                            1839030562
                                        )),
                                        i,
                                        m,
                                        d[n + 14],
                                        23, -35309556
                                    )),
                                    (r = md5_hh(
                                        r,
                                        (i = md5_hh(
                                            i,
                                            (m = md5_hh(m, f, r, i, d[n + 1], 4, -1530992060)),
                                            f,
                                            r,
                                            d[n + 4],
                                            11,
                                            1272893353
                                        )),
                                        m,
                                        f,
                                        d[n + 7],
                                        16, -155497632
                                    )),
                                    i,
                                    m,
                                    d[n + 10],
                                    23, -1094730640
                                )),
                                (r = md5_hh(
                                    r,
                                    (i = md5_hh(
                                        i,
                                        (m = md5_hh(m, f, r, i, d[n + 13], 4, 681279174)),
                                        f,
                                        r,
                                        d[n + 0],
                                        11, -358537222
                                    )),
                                    m,
                                    f,
                                    d[n + 3],
                                    16, -722521979
                                )),
                                i,
                                m,
                                d[n + 6],
                                23,
                                76029189
                            )),
                            (r = md5_hh(
                                r,
                                (i = md5_hh(
                                    i,
                                    (m = md5_hh(m, f, r, i, d[n + 9], 4, -640364487)),
                                    f,
                                    r,
                                    d[n + 12],
                                    11, -421815835
                                )),
                                m,
                                f,
                                d[n + 15],
                                16,
                                530742520
                            )),
                            i,
                            m,
                            d[n + 2],
                            23, -995338651
                        )),
                        (r = md5_ii(
                            r,
                            (i = md5_ii(
                                i,
                                (m = md5_ii(m, f, r, i, d[n + 0], 6, -198630844)),
                                f,
                                r,
                                d[n + 7],
                                10,
                                1126891415
                            )),
                            m,
                            f,
                            d[n + 14],
                            15, -1416354905
                        )),
                        i,
                        m,
                        d[n + 5],
                        21, -57434055
                    )),
                    (r = md5_ii(
                        r,
                        (i = md5_ii(
                            i,
                            (m = md5_ii(m, f, r, i, d[n + 12], 6, 1700485571)),
                            f,
                            r,
                            d[n + 3],
                            10, -1894986606
                        )),
                        m,
                        f,
                        d[n + 10],
                        15, -1051523
                    )),
                    i,
                    m,
                    d[n + 1],
                    21, -2054922799
                )),
                (r = md5_ii(
                    r,
                    (i = md5_ii(
                        i,
                        (m = md5_ii(m, f, r, i, d[n + 8], 6, 1873313359)),
                        f,
                        r,
                        d[n + 15],
                        10, -30611744
                    )),
                    m,
                    f,
                    d[n + 6],
                    15, -1560198380
                )),
                i,
                m,
                d[n + 13],
                21,
                1309151649
            )),
            (r = md5_ii(
                r,
                (i = md5_ii(
                    i,
                    (m = md5_ii(m, f, r, i, d[n + 4], 6, -145523070)),
                    f,
                    r,
                    d[n + 11],
                    10, -1120210379
                )),
                m,
                f,
                d[n + 2],
                15,
                718787259
            )),
            i,
            m,
            d[n + 9],
            21, -343485551
        )),
            (m = safe_add(m, h)),
            (f = safe_add(f, t)),
            (r = safe_add(r, g)),
            (i = safe_add(i, e));
    }
    return Array(m, f, r, i);
}

function md5_cmn(d, _, m, f, r, i) {
    return safe_add(bit_rol(safe_add(safe_add(_, d), safe_add(f, i)), r), m);
}

function md5_ff(d, _, m, f, r, i, n) {
    return md5_cmn((_ & m) | (~_ & f), d, _, r, i, n);
}

function md5_gg(d, _, m, f, r, i, n) {
    return md5_cmn((_ & f) | (m & ~f), d, _, r, i, n);
}

function md5_hh(d, _, m, f, r, i, n) {
    return md5_cmn(_ ^ m ^ f, d, _, r, i, n);
}

function md5_ii(d, _, m, f, r, i, n) {
    return md5_cmn(m ^ (_ | ~f), d, _, r, i, n);
}

function safe_add(d, _) {
    var m = (65535 & d) + (65535 & _);
    return (((d >> 16) + (_ >> 16) + (m >> 16)) << 16) | (65535 & m);
}

function bit_rol(d, _) {
    return (d << _) | (d >>> (32 - _));
}

function formatTime(d) {
    let date = new Date(d);
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    if (hh < 10) {
        hh = "0" + hh;
    }
    if (mm < 10) {
        mm = "0" + mm;
    }
    if (ss < 10) {
        ss = "0" + ss;
    }
    let result = hh + ":" + mm + ":" + ss;
    return result;
}

function formatDate(d) {
    let date = new Date(d);
    let dd = date.getDate();
    let mmm = date.getMonth() + 1;
    let yy = date.getFullYear();
    if (mmm < 10) {
        mmm = "0" + mmm;
    }
    if (dd < 10) {
        dd = "0" + dd;
    }
    let result = yy + "/" + mmm + "/" + dd;
    return result;
}

function formatDate1(d) {
    let date = new Date(d);
    let dd = date.getDate();
    let mmm = date.getMonth() + 1;
    let yy = date.getFullYear();
    if (mmm < 10) {
        mmm = "0" + mmm;
    }
    if (dd < 10) {
        dd = "0" + dd;
    }
    let result = yy + "-" + mmm + "-" + dd;
    return result;
}

function formatDateCheck(d) {
    let date = new Date(d);
    let dd = date.getDate();
    let mmm = date.getMonth() + 1;
    let yy = date.getFullYear();
    if (mmm < 10) {
        mmm = "0" + mmm;
    }
    if (dd < 10) {
        dd = "0" + dd;
    }
    let result = mmm + "/" + dd + "/" + yy;
    return result;
}

async function checkAuth(token_o) {
    let result = {};
    let split_auth = token_o.split(" ");
    let token = split_auth[1];
    let data = await queryMember.queryLogToken(token);
    if (data.status && data.result.length > 0) {
        let decodedToken = await parseJwt(token);
        result.playload = decodedToken;
        var isExpiredToken = false;
        let dateNow = new Date();
        if (decodedToken.exp < dateNow.getTime() / 1000) {
            isExpiredToken = true;
        }
        if (!isExpiredToken) {
            result.status = true;
            result.txt = token;
        } else {
            let id = data.result[0].id;
            result.status = false;
            result.msg = "Token Expired";
            await queryMember.deleteLogToken(id);
        }
    } else {
        result.status = false;
        result.msg = stt.tokenFail.description;
    }
    return result;
}

async function checkBalance() {
    /**======================api scb============================ */
    const accDeposit = await queryMember.accountBank();
    // if (accDeposit ? .result.length !== 1) return false;
    if (accDeposit.result.length !== 1) return false;
    const {
        username: deviceId,
        password: pin,
        accnum: accountNo,
    } = accDeposit.result[0];
    const scbObj = new scb(deviceId, pin);
    let dataBalance = {
        accountNo: accountNo,
    };
    const resTrans = await scbObj.checkBalance(dataBalance);
    if (resTrans) {
        return resTrans;
    } else {
        return false;
    }
}

module.exports.testSCB = async (req, res) => {
    res.setHeader("Content-Type", "application/json");
    let result = await checkBalance();
    res.send(result);
};

function formatDateBase(d) {
    let date = new Date(d);
    let dd = date.getDate();
    let mmm = date.getMonth() + 1;
    let yy = date.getFullYear();
    if (mmm < 10) {
        mmm = "0" + mmm;
    }
    if (dd < 10) {
        dd = "0" + dd;
    }
    let result = dd + "-" + mmm + "-" + yy;
    return result;
}

function formatDateBaseMonth(d) {
    let date = new Date(d);
    let dd = date.getDate();
    let mmm = date.getMonth() + 1;
    let yy = date.getFullYear();
    if (mmm < 10) {
        mmm = "0" + mmm;
    }
    if (dd < 10) {
        dd = "0" + dd;
    }
    let result = mmm + "-" + yy;
    return result;
}

function formatDateBaseMonthLotto(d) {
    let date = new Date(d);
    let dd = date.getDate();
    let mmm = date.getMonth() + 1;
    let yy = date.getFullYear();
    if (mmm < 10) {
        mmm = "0" + mmm;
    }
    if (dd < 10) {
        dd = "0" + dd;
    }
    let result = yy + "-" + mmm;
    return result;
}

function sendMessageLineNotify(token, messageBody) {
    request({
        method: "POST",
        uri: "https://notify-api.line.me/api/notify",
        headers: {
            "Content-Type": "application/json",
        },
        auth: {
            bearer: token,
        },
        form: {
            message: messageBody,
        },
    });
}

async function authenParse(token) {
    try {
        let split = token;
        let parseToken = split.split("Bearer ");
        let result = await parseJwt(parseToken[1]);
        console.log(parseToken[0]);
        console.log(parseToken[1]);
        return result;
    } catch (e) {
        return false;
    }
}

function generateAccessToken(params) {
    return new Promise((resolve, reject) => {
        let payload = params;
        let secret = "eyJhbGciOiJIUzI1N";
        var token = jwt.sign(payload, secret, {
            expiresIn: "2h",
        });
        resolve(token);
    });
}

function parseJwt(token) {
    var base64Payload = token.split(".")[1];
    var payload = Buffer.from(base64Payload, "base64");
    return JSON.parse(payload.toString());
}


// ###########################  Unity Function #########################################

module.exports.balanceKBANK = async (req, res) => {
    const resTrans = await kbankObj.balance();
    res.send(resTrans);
};

module.exports.activitiesKBANK = async (req, res) => {
    const resTrans = await kbankObj.activities();
    res.send(resTrans);
};

module.exports.activitiesDetailKBANK = async (req, res) => {
    const resTrans = await kbankObj.activitiesDetail(req.params.rqUid);
    res.send(resTrans);
};

module.exports.bankInfoListKBANK = async (req, res) => {
    const resTrans = await kbankObj.bankInfoList();
    res.send(resTrans);
};

module.exports.inquireForTransferMoney = async (req, res) => {
    res.setHeader("Content-Type", "application/json");
    console.log(req.body);
    const resTrans = await kbankObj.inquireForTransferMoney(req.body);
    res.send(resTrans);

};

module.exports.transferMoney = async (req, res) => {
    res.setHeader("Content-Type", "application/json");

    const resTrans = await kbankObj.transferMoney(req.params);
    res.send(resTrans);
};



