var gulp  = require('gulp');
var del   = require('del');
var paths = require('../config').paths;

// Clean Output Directory
gulp.task('clean', del.bind(null, [paths.dist]));
