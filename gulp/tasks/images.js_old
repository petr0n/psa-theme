var gulp     = require('gulp');
var changed  = require('gulp-changed');
var imagemin = require('gulp-imagemin');
var paths    = require('../config').paths;

gulp.task('images', function() {
  return gulp.src(paths.images + '/**')
    .pipe(changed(paths.dist + '/images')) // Only apply to changed files
    .pipe(imagemin()) // Optimize
    .pipe(gulp.dest(paths.dist + '/images'));
});
