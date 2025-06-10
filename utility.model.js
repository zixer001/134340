const mysql = require('../../config/mysql');
module.exports = {
    queryOne: (sql) => {
        return new Promise(function (resolve, reject) {
            con.query(sql, function (err, result) {
                if (!err) {
                    resolve(result);
                } else {
                    reject(err);
                }
            });
        });
    },
    insertOne: (sql) => {
        return new Promise(function (resolve, reject) {
            con.query(sql, function (err, result) {
                if (!err) {
                    resolve(result);
                } else {
                    reject(err);
                }
            });
        });
    },
    insertMany: (sql, value) => {
        return new Promise(function (resolve, reject) {
            con.query(sql, value, function (err, result) {
                if (!err) {
                    resolve(result);
                } else {
                    reject(err);
                }
            });
        });
    },
    deleteOne: (sql) => {
        return new Promise(function (resolve, reject) {
            con.query(sql, function (err, result) {
                if (!err) {
                    resolve(result);
                } else {
                    reject(err);
                }
            });
        });
    },
    updateOne: (sql) => {
        return new Promise(function (resolve, reject) {
            con.query(sql, function (err, result) {
                if (!err) {
                    resolve(result);
                } else {
                    reject(err);
                }
            });
        });
    },
}