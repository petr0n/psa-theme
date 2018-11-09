var gulp = require('gulp');
var less = require('gulp-less');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var plumber = require('gulp-plumber');
var uglify = require('gulp-uglify');
var browserSync = require('browser-sync');
var handleErrors = require('../util/handleErrors');
var paths = require('../config').paths;

gulp.task('adminScripts', function() {
  return gulp.src([paths.scripts + '/admin/admin.js'])
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(gulp.dest(paths.dist + '/scripts'))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(uglify())
    .pipe(gulp.dest(paths.dist + '/scripts'))
    .pipe(browserSync.reload({
      stream: true
    }));
});

gulp.task('adminStyles', function() {
  return gulp.src([paths.styles + '/admin/admin.less'])
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(less())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest(paths.dist + '/styles'))
    .pipe(minifycss({
      processImport: false
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(paths.dist + '/styles'))
    .pipe(browserSync.reload({
      stream: true
    }));
});

gulp.task('editorStyles', function() {
  return gulp.src([paths.styles + '/admin/editor.less'])
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(less())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest(paths.dist + '/styles'))
    .pipe(minifycss({
      processImport: false
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(paths.dist + '/styles'))
    .pipe(browserSync.reload({
      stream: true
    }));
});

gulp.task('admin', ['adminScripts', 'adminStyles', 'editorStyles']);
