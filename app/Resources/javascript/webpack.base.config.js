const path = require('path');

module.exports = {
  entry: ['babel-polyfill', './main.js', '../sass/main.sass'],
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, '../../../web/j')
  },
  devtool: "source-map"
};
