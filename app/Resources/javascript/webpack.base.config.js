const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const NODE_ENV = process.env.NODE_ENV;
const isDevelopment = NODE_ENV === 'development';

module.exports = {
  entry: ['./main.js', '../sass/main.sass'],
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, '../../../web/j')
  },
  devtool: "source-map",
  plugins: [
    new MiniCssExtractPlugin({
      filename: '../c/[name].css'
    }),
    new UglifyJsPlugin({
      sourceMap: true,
      extractComments: true,
    })
  ],
  optimization: {
    // We no not want to minimize our code.
    minimize: !isDevelopment
  },
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
          outputStyle: isDevelopment ? 'expanded' : 'compressed',
          sourceComments: isDevelopment,
          sourceMap: true,
          outFile: path.resolve(__dirname, '../../../web/c')
        }
      }]
    }]
  }
};
