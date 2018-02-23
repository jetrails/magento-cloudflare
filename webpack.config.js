const path = require ("path");
const webpack = require ("webpack");
const extract = require ("extract-text-webpack-plugin")

const BUILD_DIR = path.resolve ( path.join ( __dirname, "build" ) )
const SOURCE_DIR = path.resolve ( path.join ( __dirname, "src" ) )
const PROJECT_DIR = __dirname

module.exports = {
	entry: path.join ( SOURCE_DIR, "skin", "adminhtml", "base", "default", "js", "cloudflare", "index.js" ),
	output: {
		path: BUILD_DIR,
		filename: "bundle.js"
	},
	resolve: {
		modules: [
			path.resolve ( path.join ( PROJECT_DIR, "node_modules" ) ),
			path.resolve ( path.join ( SOURCE_DIR, "skin", "adminhtml", "base", "default", "js" ) )
		]
	},
	stats: {
        assets: false,
        children: false,
        chunks: false,
        hash: false,
        modules: false,
        publicPath: false,
        timings: false,
        version: false,
        warnings: true
	}
};
