var gulp = require('gulp'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename');

gulp.task('compress', function() {
	gulp.src('public/assets/js/public.js')
		.pipe(rename('public-min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('public/assets/js/min/'));
});

gulp.task('default', ['compress']);