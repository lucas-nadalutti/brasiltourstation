var gulp = require('gulp'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass');

gulp.task('default', function() {
  // place code for your default task here
});

gulp.task('sass', function (){
    gulp.src('webroot/scss/*.scss')
        .pipe(sass({style: 'compressed', errLogToConsole: true}))
        .pipe(concat('main.css'))
        .pipe(gulp.dest('webroot/css/'));
});