const axios = require("axios");
var qs = require('qs');

let USER_AGENT = 'Super Idol的笑容 都没你的甜 八月正午的阳光 都没你耀眼 热爱 105 °C的你 滴滴清纯的蒸馏水 你不知道你有多可爱';
class Truewallet {

    constructor() {

    }

    checkVoucher = async (data) => {
        var config = {
            method: 'get',
            url: 'https://gift.truemoney.com/campaign/vouchers/lbzhu2s1lW4de9Zdba/verify?mobile=0846105966',
            headers: {
                'Content-Type': 'application/json',
                'user-agent': USER_AGENT
            }
        };
        return axios(config)
            .then(function (response) {
                return response.data;
            })
            .catch(function (error) {
                console.log(error);
                return error;
            });
    };

}
module.exports = Truewallet;