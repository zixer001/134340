// const mysql = require('./config/mysql');
const app = require('./config/express')();
const port = 13000;
// mysql.db(async function(db) {
// if (db) {
app.listen(port);
module.exports = app;
console.log('Kbank API running at port ' + port);

// } else {
// logError.historyLogError(JSON.stringify(db));
// console.log('Kbank API is error ');
    // }
// });