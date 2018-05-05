const path = require('path');

const ASSETS_PATH = path.resolve(__dirname, '../../web/assets');
const JS_PATH = path.resolve(__dirname, 'js');
const SASS_PATH = path.resolve(__dirname, 'sass');

module.exports = {
  devtool: "source-map",
  entry: [
    'babel-polyfill',
    JS_PATH + '/main.js',
    SASS_PATH + '/main.sass'
  ],
  output: {
    filename: '[name].js',
    path: ASSETS_PATH
  },
  stats: {
    all: false,
    builtAt: true,
    assets: true,
    cached: true
  }
};
