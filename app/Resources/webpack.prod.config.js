const merge = require('webpack-merge');
const baseConfig = require('./webpack.base.config.js');

const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyWebpackPlugin = require('copy-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

const ASSETS_PATH = path.resolve(__dirname, '../../../web/assets');
const JS_PATH = path.resolve(__dirname, 'js');
const SASS_PATH = path.resolve(__dirname, 'sass');

module.exports = merge(baseConfig, {
  mode: 'production',
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css'
    }),
    new CopyWebpackPlugin([{
      from: path.resolve(__dirname, 'node_modules/leaflet/dist/images/marker-shadow.png'),
      to: path.resolve(__dirname, '../../web/assets/images/marker-shadow.png')
    }]),
    new UglifyJsPlugin({
      sourceMap: true,
      extractComments: true,
    })
  ],
  module: {
    rules: [{
      test: /\.(sa|c)ss$/,
      loader: [
        MiniCssExtractPlugin.loader,
        {
          loader: "css-loader",
          options: {
            sourceMap: true,
            importLoaders: 1,
            alias: {
              './images/layers.png': path.resolve(__dirname, 'node_modules/leaflet/dist/images/layers.png'),
              './images/layers-2x.png': path.resolve(__dirname, 'node_modules/leaflet/dist/images/layers-2x.png'),
              './images/marker-icon.png': path.resolve(__dirname, 'node_modules/leaflet/dist/images/marker-icon.png'),
              './images/marker-icon-2x.png': path.resolve(__dirname, 'node_modules/leaflet/dist/images/marker-icon-2x.png'),
              './images/marker-shadow.png': path.resolve(__dirname, 'node_modules/leaflet/dist/images/marker-shadow.png'),
            }
          }
        }, {
          loader: "sass-loader",
          options: {
            includePaths: [SASS_PATH],
            indentedSyntax: true,
            indentWidth: 4,
            outputStyle: 'compressed',
            sourceComments: false,
            sourceMap: true,
            outFile: ASSETS_PATH
          }
        }
      ]
    }, {
      // This is for leaflet...
      test: /\.(png|jpe?g|gif)$/,
      loader: 'file-loader',
      options: {
        name: 'images/[name].[ext]',
      }
    }, {
      test : /\.js$/,
      exclude: [/(node_modules)/],
      include : JS_PATH,
      loader : 'babel-loader'
    }]
  }
});
