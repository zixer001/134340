const express = require('express');
const bodyParser = require('body-parser');
module.exports = () => {
  let app = express();
  app.use(function (req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET,POST,PUT');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization');
    app.locals.pretty = true;
    return next();
  });
  app.use(bodyParser.urlencoded({
    extended: true,
    limit: '100mb'
  }));
  app.use(bodyParser.json({
    limit: '100mb'
  }));
  require('../app/route/backend.route')(app)
  return app;
}