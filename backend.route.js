const controllerMember = require('../controllers/backend.controller');
module.exports = (app) => {
    app.get('/balance', controllerMember.balanceKBANK);
    app.get('/activities', controllerMember.activitiesKBANK);
    app.get('/activity-detail/:rqUid', controllerMember.activitiesDetailKBANK);
    app.get('/bank-info-list', controllerMember.bankInfoListKBANK);
    app.post('/inquire-for-transfer-money', controllerMember.inquireForTransferMoney);

    app.post('/transfer-money78/:kbankInternalSessionId', controllerMember.transferMoney);
}