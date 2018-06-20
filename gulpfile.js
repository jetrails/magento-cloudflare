const concat = require ("gulp-concat")
const fs = require ("fs")
const gulp = require ("gulp")
const gzip = require ("gulp-gzip")
const path = require ("path")
const config = require ( path.join ( __dirname, "package.json" ) )
const magepack = require ("gulp-magepack")
const minify = require ("gulp-minify-css")
const minifyJs = require ("gulp-minify")
const sass = require ("gulp-sass")
const uglify = require ("gulp-uglify")
const webpack = require ("webpack")
const webpackStream = require ("webpack-stream")
const webpackConfig = require ( path.join ( __dirname, "webpack.config.js" ) )
const tar = require ("gulp-tar")

const EXTENSION_NAMESPACE = "JetRails_Cloudflare"
const EXTENSION_VERSION = config.version

const MODULE_SHORT_NAME = config.name.replace ( /^.*-/, "" )
const SOURCE_DIR = "src"
const BUILD_DIR = "build"
const STAGING_DIR = "staging"
const SOURCE_PATH = path.join ( __dirname, SOURCE_DIR )
const BUILD_PATH = path.join ( __dirname, BUILD_DIR )
const STAGING_PATH = path.join ( __dirname, STAGING_DIR )
const MAGENTO_SKIN_CSS = path.join ( "skin", "adminhtml", "base", "default", "css" )
const MAGENTO_SKIN_SCSS = path.join ( "skin", "adminhtml", "base", "default", "scss" )
const MAGENTO_SKIN_JS = path.join ( "skin", "adminhtml", "base", "default", "js" )

gulp.task ( "default", [ "build-styles", "build-scripts" ] );
gulp.task ( "deploy", [ "deploy-staging" ] );

gulp.task ( "init", [], ( callback ) => {
	if ( !fs.existsSync ( SOURCE_PATH ) ) fs.mkdirSync ( SOURCE_PATH )
	if ( !fs.existsSync ( BUILD_PATH ) ) fs.mkdirSync ( BUILD_PATH )
	if ( !fs.existsSync ( STAGING_PATH ) ) fs.mkdirSync ( STAGING_PATH )
	callback ()
})

gulp.task ( "build-styles", [ "init" ], ( callback ) => {
	gulp.src ( path.join ( SOURCE_PATH, MAGENTO_SKIN_SCSS, MODULE_SHORT_NAME, "index.scss" ) )
		.pipe ( sass ({ includePaths: path.join ( SOURCE_PATH, MAGENTO_SKIN_SCSS ) }) )
		.pipe ( minify () )
		.pipe ( concat ("bundle.min.css") )
		.pipe ( gulp.dest ( path.join ( BUILD_PATH, MAGENTO_SKIN_CSS, MODULE_SHORT_NAME ) ) )
		.on ( "end", callback )
})

gulp.task ( "build-scripts", [ "init" ], ( callback ) => {
	gulp.src ( path.join ( SOURCE_PATH, MAGENTO_SKIN_JS, MODULE_SHORT_NAME, "index.js" ) )
	    .pipe ( webpackStream ( webpackConfig ), webpack )
		.pipe ( minifyJs ({ ext: { min: ".min.js" } }) )
	    .pipe ( gulp.dest ( path.join ( BUILD_PATH, MAGENTO_SKIN_JS, MODULE_SHORT_NAME ) ) )
		.on ( "end", () => {
			fs.unlinkSync ( path.join ( BUILD_PATH, MAGENTO_SKIN_JS, MODULE_SHORT_NAME, "bundle.js" ) )
			callback ()
		})
})

gulp.task ( "deploy-source", [ "build-styles", "build-scripts" ], function ( callback ) {
	var sourceFiles = path.join ( SOURCE_PATH, "**", "*" )
	var notStyle = "!" + path.join ( SOURCE_PATH, "**", "js", "**/" )
	var notScript = "!" + path.join ( SOURCE_PATH, "**", "scss", "**/" )
	var notScriptFolder = "!" + path.join ( SOURCE_PATH, "**", "scss" )
	gulp.src ([ path.join ( SOURCE_PATH, MAGENTO_SKIN_SCSS, MODULE_SHORT_NAME, "fonts", "**", "*" ) ])
		.pipe ( gulp.dest ( path.join ( BUILD_PATH, MAGENTO_SKIN_CSS, MODULE_SHORT_NAME, "fonts" ) ) )
	gulp.src ([ sourceFiles, notStyle, notScript, notScriptFolder ])
		.pipe ( gulp.dest ( path.join ( BUILD_PATH ) ) )
		.on ( "end", callback )
});

gulp.task ( "deploy-staging", [ "deploy-source", ], function ( callback ) {
	gulp.src ( path.join ( BUILD_PATH, "**", "*" ) )
		.pipe ( gulp.dest ( path.join ( STAGING_PATH ) ) )
		.on ( "end", callback )
});

gulp.task ( "watch", [ "deploy-staging" ], () => {
	gulp.watch ( path.join ( SOURCE_PATH, "**", "*" ), [ "deploy-staging" ] );
	gulp.watch ( path.join ( SOURCE_PATH, "**", "*.scss" ), [ "deploy-staging" ] );
	gulp.watch ( path.join ( SOURCE_PATH, "**", "*.js" ), [ "deploy-staging" ] );
})

gulp.task ( "package", () => {
	let options = {
		"template": "package.xml",
		"output": "package.xml",
		"version": EXTENSION_VERSION
	}
    gulp.src ([ path.join ( BUILD_PATH, "**", "*" ) ])
		.pipe ( magepack ( options ) )
		.pipe ( tar (`${EXTENSION_NAMESPACE}-${EXTENSION_VERSION}`) )
        .pipe ( gzip ({ extension: "tgz" }) )
        .pipe ( gulp.dest ("dist") )
})
