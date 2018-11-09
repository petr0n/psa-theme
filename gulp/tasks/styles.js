var gulp         = require('gulp');
var gutil        = require('gulp-util');
var less         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-clean-css');
var rename       = require('gulp-rename');
var plumber      = require('gulp-plumber');
var browserSync  = require('browser-sync');
var handleErrors = require('../util/handleErrors');
var paths        = require('../config').paths;

var dest = paths.dist + '/styles';

gulp.task('styles', function() {
  return gulp.src([paths.styles + '/app.scss'])
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(less())
    .pipe(autoprefixer())
    .pipe(gulp.dest(dest))
    //.pipe(minifycss({ processImport: false }))
    //.pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(dest))
    .pipe(browserSync.reload({
      stream: true
    }));
});
