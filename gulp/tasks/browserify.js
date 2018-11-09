var gulp         	= require('gulp');
var gutil        	= require('gulp-util');
var rename       	= require('gulp-rename');
var uglify       	= require('gulp-uglify');
var browserify   	= require('browserify');
var watchify     	= require('watchify');
var streamify    	= require('gulp-streamify');
var plumber      	= require('gulp-plumber');
var browserSync  	= require('browser-sync');
var handleErrors 	= require('../util/handleErrors');
var paths        	= require('../config').paths;
var source 		 	= require('vinyl-source-stream')
var assign 		 	= require('lodash.assign');

var sourceFile 		= paths.scripts + '/app.js';
var destFolder 		= paths.dist + '/scripts';
var destFile 		= 'app.js';


// Hack to enable configurable watchify watching
var watching = false
gulp.task('enable-watch-mode', function() {
	watching = true
});

// add custom browserify options here
var customOpts = {
  entries: [ paths.scripts + '/app.js'],
  debug: true
};
var opts = assign({}, watchify.args, customOpts);
var b = watchify(browserify(opts)); 

// add transformations here
// i.e. b.transform(coffeeify);

gulp.task('js', bundle); // so you can run `gulp js` to build the file
b.on('update', bundle); // on any dep update, runs the bundler
b.on('log', gutil.log); // output build logs to terminal

function bundle() {
	return b.bundle()
		.on('error', gutil.log.bind(gutil, 'Browserify Error'))
		.pipe(source(destFile))
		.pipe(gulp.dest(destFolder))
		.pipe(browserSync.reload({ stream: true }));
}
