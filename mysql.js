var mysql = require('mysql');
const dbConfig = require('../constants/dbCon');
module.exports.db = (callback) => {
	con = mysql.createConnection({
		host: dbConfig.host,
		user: dbConfig.user,
		password: dbConfig.password,
		database: dbConfig.database
	});
	con.connect(function (err) {
		if (err) {
			console.log(err);
			console.log("Database QR Code Fail Connected!");
			callback({
				status: false,
			});
		} else {
			console.log("Database QR Code Connected!");
			callback({ status: true });
		}
	});


}



