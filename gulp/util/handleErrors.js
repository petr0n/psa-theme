var gutil = require('gulp-util');

module.exports = function(err) {
	gutil.log('Error:', err.message);
	gutil.beep(); // Audible notification
	this.emit('end'); // Keep gulp from hanging on this task
};
