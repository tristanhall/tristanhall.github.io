'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var util = require('gulp-util');
var concat = require('gulp-concat');

gulp.task('default', ['sass', 'js']);

gulp.task('watch', ['sass:watch', 'js:watch']);

gulp.task('sass', function() {
    return gulp
        .src('assets/scss/main.scss')
        .pipe(sass({
            compass: false,
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('sass:watch', function() {
    gulp.watch('assets/scss/**/*.scss', ['sass']);
});

gulp.task('js', function() {
    return gulp
        .src([
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/slick-carousel/slick/slick.min.js',
            'bower_components/angular/angular.min.js',
            'bower_components/angular-slick/dist/slick.min.js',
            'bower_components/walkway/walkway.min.js',
            'assets/src/main.js'
        ])
        .pipe(concat('main.js'))
        .pipe(uglify())
        .on('error', util.log)
        .pipe(gulp.dest('assets/js'));
});

gulp.task('js:watch', function() {
    gulp.watch('assets/src/**/*.js', ['js']);
});