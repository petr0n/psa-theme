var gulp    = require('gulp');
var changed = require('gulp-changed');

gulp.task('build', ['browserify', 'styles']);
