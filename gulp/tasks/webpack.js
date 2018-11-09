var gulp         = require('gulp');
var gutil        = require('gulp-util');
var webpack      = require('webpack');
var plumber      = require('gulp-plumber');
var handleErrors = require('../util/handleErrors');
var paths        = require('../config').paths;

var webpackOptions = {
  watchDelay: 200
};
var webpackConfig = {
  useMemoryFs: true,
  progress: true
};

gulp.task('webpack', [], function() {
  return gulp.src('./' + webpack.config.CONFIG_FILENAME, {
      base: process.cwd()
    })
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(webpack.configure(webpackConfig))
    .pipe(webpack.overrides(webpackOptions))
    .pipe(webpack.compile())
    .pipe(webpack.format({
      version: false,
      timings: true
    }))
    .pipe(webpack.failAfter({
      errors: false,
      warnings: false
    }))
    .pipe(gulp.dest(process.cwd()));
});
