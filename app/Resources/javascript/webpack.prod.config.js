const merge = require('webpack-merge');
const baseConfig = require('./webpack.base.config.js');

const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = merge(baseConfig, {
  mode: 'production',
  plugins: [
    new MiniCssExtractPlugin({
      filename: '../c/[name].css'
    }),
    new UglifyJsPlugin({
      sourceMap: true,
      extractComments: true,
    })
  ],
  module: {
    rules: [{
      test: /\.sass$/,
      use: [{
        loader: MiniCssExtractPlugin.loader
      }, {
        loader: "css-loader",
        options: {
          sourceMap: true
        }
      }, {
        loader: "sass-loader",
        options: {
          includePaths: ["../sass"],
          indentedSyntax: true,
          indentWidth: 4,
          outputStyle: 'compressed',
          sourceComments: false,
          sourceMap: true,
          outFile: path.resolve(__dirname, '../../../web/c')
        }
      }]
    }, {
      test : /\.js$/,
      exclude: [/(node_modules)/],
      include : path.resolve(__dirname, './'),
      loader : 'babel-loader'
    }]
  }
});
