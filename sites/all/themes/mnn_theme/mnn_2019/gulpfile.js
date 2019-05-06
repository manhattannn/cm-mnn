var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var exec = require('child_process').exec;
var runSequence = require('run-sequence');
var autoprefixer = require('gulp-autoprefixer');

// Scss task
gulp.task('scss', function () {
  gulp.src('scss/app.scss')
    .pipe(sass())
    // Autoprefixer
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    // Set specific CSS file
    .pipe(concat('app.min.css'))
    // Clean and minify
    .pipe(cleanCSS({compatibility: 'ie9'}))
    // Set destination directory
    .pipe(gulp.dest('css'));
});

// Watch task to run on save
gulp.task('default', function () {
  gulp.watch(['scss/**/*.scss'], ['scss']);
});

// Compile everything once
// @todo add better comment
gulp.task('build', function (cb) {
  runSequence(
    'scss',
  cb)
});

// Just incase someone tries to run 'gulp watch' instead of just 'gulp'
gulp.task('watch', ['default']);

// Catch errors instead of crashing (http://maximilianschmitt.me/posts/prevent-gulp-js-from-crashing-on-error/)
function onError(err) {
  console.log(err);
  this.emit('end');
}
