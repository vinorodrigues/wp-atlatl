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

gulp.task( 'sass:css', function(cb) {
	return gulp.src( './scss/**/*.scss' )
		.pipe( maps.init() )
		.pipe( sass( {
			outputStyle: 'expanded',
			errorLogToConsole: true
			} ) )
		.pipe( maps.write( '.' ) )
		.on( 'error', console.error.bind( console ))
		.pipe( gulp.dest( './css' ) );
});

gulp.task( 'sass:min', function(cb) {
    return gulp.src( ['./css/**/*.css', '!./css/**/*.min.css'] )
        .pipe( cmin() )
        .pipe( renm( {
        	suffix: '.min'
	        }) )
        .pipe( gulp.dest('./css') );
});

gulp.task( 'sass:f6:css', function(cb) {
	return gulp.src( './on/foundation6/scss/**/*.scss' )
		.pipe( maps.init() )
		.pipe( sass( {
			outputStyle: 'expanded',
			errorLogToConsole: true,
			includePaths: [
				'./node_modules/foundation-sites/scss',
				'./node_modules/foundation-sites/scss/util',
				'./node_modules/foundation-sites/scss/prototype'
			]
			} ) )
		.pipe( maps.write( '.' ) )
		.on( 'error', console.error.bind( console ))
		.pipe( gulp.dest( './on/foundation6/css' ) );
});

gulp.task( 'sass:f6:min', function(cb) {
    return gulp.src( ['./on/foundation6/css/**/*.css', '!./on/foundation6/css/**/*.min.css', '!./on/foundation6/css/foundation.min.css'] )
        .pipe( cmin() )
        .pipe( renm( {
        	suffix: '.min'
	        }) )
        .pipe( gulp.dest('./on/foundation6/css') );
});

gulp.task( 'sass:f6' , gulp.series( 'sass:f6:css', 'sass:f6:min' ) );

gulp.task( 'sass' , gulp.series( 'sass:css', 'sass:min', 'sass:f6:css', 'sass:f6:min' ) );

gulp.task('images', function(cb){
	return gulp.src( './imgsrc/**/*.+(png|jpg|gif|svg)' )
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
		.pipe( gulp.dest( './img') )
});

gulp.task( 'js', function(cb) {
    return gulp.src( ['js/**/*.js', '!js/**/*.min.js'] )
        .pipe( ugly( {
        	mangle: false
	        }) )
        .pipe( renm( {
        	suffix: '.min'
	        }) )
		.on( 'error', console.error.bind( console ))
        .pipe( gulp.dest('./js') );
});

gulp.task( 'watch', function(cb){
	gulp.watch( './scss/**/*.scss', gulp.parallel('sass:css') );
	gulp.watch( ['./css/**/*.css', '!./css/**/*.min.css'], gulp.parallel('sass:min') );
	gulp.watch( './on/foundation6/scss/**/*.scss', gulp.parallel('sass:f6:css') );
	gulp.watch( ['./on/foundation6/css/**/*.css', '!./on/foundation6/css/**/*.min.css', '!./on/foundation6/css/foundation.min.css'], gulp.parallel('sass:f6:min') );
	gulp.watch( './imgsrc/**/*.+(png|jpg|gif|svg)', gulp.parallel('images') );
	gulp.watch( ['js/**/*.js', '!js/**/*.min.js'], gulp.parallel('js') );
});

gulp.task( 'default' , gulp.series( 'sass', 'images', 'js' ) );
