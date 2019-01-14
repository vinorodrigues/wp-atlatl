/**
 * Gulp file
 */

var gulp = require( 'gulp' );
var sass = require( 'gulp-sass' );
sass.compiler = require( 'node-sass' );
var maps = require( 'gulp-sourcemaps' );
var cmin = require( 'gulp-cssnano' );
var imin = require( 'gulp-imagemin' );
var renm = require( 'gulp-rename' );
var ugly = require( 'gulp-uglify' );

var paths = {
	sassSrc: './scss/**/*.scss',
	cssSrc: [
		'./css/**/*.css',
		'!./css/**/*.min.css'
		],
	cssOut: './css',
	sassFoundationSrc: './on/foundation6/scss/**/*.scss',
	sassFoundationIncludes: [
		'./node_modules/foundation-sites/scss',
		'./node_modules/foundation-sites/scss/util',
		'./node_modules/foundation-sites/scss/prototype'
		],
	cssFoundationOut: './on/foundation6/css',
	imgSrc: './imgsrc/**/*.+(png|jpg|gif|svg)',
	imgOut: './img',
	jsSrc: [
		'js/**/*.js',
		'!js/**/*.min.js'
		],
	jsOut: './js'
}

gulp.task( 'sass:css', function(cb) {
	return gulp.src( paths.sassSrc )
		.pipe( maps.init() )
		.pipe( sass( {
			outputStyle: 'expanded',
			errorLogToConsole: true
			} ) )
		.pipe( maps.write( '.' ) )
		.on( 'error', console.error.bind( console ))
		.pipe( gulp.dest( paths.cssOut ) );
});

gulp.task( 'sass:min', function(cb) {
	return gulp.src( paths.cssSrc )
		.pipe( cmin() )
		.pipe( renm( {
			suffix: '.min'
			}) )
		.pipe( gulp.dest( paths.cssOut ) );
});

gulp.task( 'sass:f6:css', function(cb) {
	return gulp.src( paths.sassFoundationSrc )
		.pipe( maps.init() )
		.pipe( sass( {
			outputStyle: 'expanded',
			errorLogToConsole: true,
			includePaths: paths.sassFoundationIncludes
			} ) )
		.pipe( maps.write( '.' ) )
		.on( 'error', console.error.bind( console ))
		.pipe( gulp.dest( './on/foundation6/css' ) );
});

gulp.task( 'sass:f6:min', function(cb) {
	return gulp.src( paths.sassFoundationSrc )
		.pipe( maps.init() )
		.pipe( sass( {
			outputStyle: 'compressed',
			errorLogToConsole: true,
			includePaths: paths.sassFoundationIncludes
			} ) )
		.on( 'error', console.error.bind( console ))
        .pipe( renm( {
        	suffix: '.min'
	        }) )
		.pipe( gulp.dest( paths.cssFoundationOut ) );
});

gulp.task( 'sass:f6' , gulp.series( 'sass:f6:css', 'sass:f6:min' ) );

gulp.task( 'sass' , gulp.series( 'sass:css', 'sass:min', 'sass:f6:css', 'sass:f6:min' ) );

gulp.task('images', function(cb){
	return gulp.src( paths.imgSrc )
		.pipe( imin( [
			imin.gifsicle({interlaced: true}),
			imin.jpegtran({progressive: true}),
			imin.optipng({optimizationLevel: 5}),
			imin.svgo({
				plugins: [
					{removeDoctype: true},
					{removeXMLProcInst: true},
					{removeComments: true},
					{removeMetadata: true},
					{removeTitle: true},
					{removeDesc: true},
					{removeEditorsNSData: true},
					{removeEmptyAttrs: true},
					{removeHiddenElems: true},
					{removeEmptyText: true},
					{removeEmptyContainers: true},
					{removeViewBox: true},
					{removeUselessStrokeAndFill: true},
					{cleanupIDs: true}
					]
				})
			]) )
		.on( 'error', console.error.bind( console ))
		.pipe( gulp.dest( paths.imgOut ) )
});

gulp.task( 'js', function(cb) {
    return gulp.src( paths.jsSrc )
        .pipe( ugly( {
        	mangle: false
	        }) )
        .pipe( renm( {
        	suffix: '.min'
	        }) )
		.on( 'error', console.error.bind( console ))
        .pipe( gulp.dest( paths.jsOut ) );
});

gulp.task( 'watch', function(cb){
	gulp.watch( paths.sassSrc, gulp.parallel('sass:css') );
	gulp.watch( paths.cssSrc, gulp.parallel('sass:min') );
	gulp.watch( paths.sassFoundationSrc, gulp.parallel('sass:f6:css') );
	gulp.watch( paths.sassFoundationSrc, gulp.parallel('sass:f6:min') );
	gulp.watch( paths.imgSrc, gulp.parallel('images') );
	gulp.watch( paths.jsSrc, gulp.parallel('js') );
});

gulp.task( 'default' , gulp.series( 'sass', 'images', 'js' ) );
