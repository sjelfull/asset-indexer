const webpack = require('webpack');
const entry = {
	'assetindexer': './source/js/assetindexer.js'
};

module.exports = {
  entry,
  output: {
    path: 'resources/js/',
    publicPath: '/',
    filename: '[name].js',
  },
  externals: {
    //"largeupload-config": "window.LargeUpload"
	// require("jquery") is external and available
	//  on the global var jQuery
	//"uservoice": "UserVoice"
    "craft": "Craft"
  },
  stats: {
    colors: true,
    reasons: true
  },
  module: {
    loaders: [
      {
        test: /.js?$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
        query: {
          presets: ['es2015']
        }
      },
      { test: /\.css$/, loader: "style-loader!css-loader" },
      { test: /\.png$/, loader: "url-loader?limit=100000" },
      { test: /\.jpg$/, loader: "file-loader" },
      { test: /\.vue$/, loader: "vue" }
    ]
  },
  vue: {
      loaders: {
          js: 'babel'
      }
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery",
      //"window.LargeUpload": "window.LargeUpload"
    })
  ]
};