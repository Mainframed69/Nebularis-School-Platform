var gulp = require('gulp');
var lessToScss = require('gulp-less-to-scss');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const watch = require('gulp-watch');
const cssmin = require('gulp-cssmin');
var sourcemaps = require('gulp-sourcemaps');
var livereload = require('gulp-livereload');

gulp.task('serve', function () {
    "use strict";
    browserSync.init({
        proxy: "http://lms.loc",
        host: "192.168.0.124",
        port: 3000,
        notify: true,
        ui: {
            port: 3001
        },
        open: false
    });
});

gulp.task('watch', function () {
    livereload.listen();

    watch('./**/*.*').on('change', function(){
        gulpCopyPlugin();
    });

    watch('./post_type/metaboxes/assets/scss/*.scss').on('change', (e) => {
        gulp.src('./post_type/metaboxes/assets/scss/*.scss')
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(cssmin())
            .pipe(gulp.dest('./post_type/metaboxes/assets/css'))
            .pipe(browserSync.stream())
            .pipe(livereload());
    });

    watch('./assets/scss/*.scss').on('change', (e) => {
        var src = e.split('masterstudy-lms-learning-management-system');
        src = src[1];
        gulp.src('.' + src)
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(cssmin())
            .pipe(gulp.dest('./assets/css'))
            .pipe(browserSync.stream())
            .pipe(livereload());
    });

    watch('./assets/scss/parts/*.scss').on('change', (e) => {
        var src = e.split('masterstudy-lms-learning-management-system');
        src = src[1];
        gulp.src('.' + src)
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(cssmin())
            .pipe(gulp.dest('./assets/css/parts'))
            .pipe(browserSync.stream())
            .pipe(livereload());
    });

    watch('./assets/scss/parts/courses/*.scss').on('change', (e) => {
        var src = e.split('masterstudy-lms-learning-management-system');
        src = src[1];
        gulp.src('.' + src)
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(cssmin())
            .pipe(gulp.dest('./assets/css/parts/courses'))
            .pipe(browserSync.stream())
            .pipe(livereload());
    });

    watch('./assets/scss/components/*.scss').on('change', (e) => {
        gulp.src('./assets/scss/*.scss')
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(cssmin())
            .pipe(gulp.dest('./assets/css'))
            .pipe(browserSync.stream())
            .pipe(livereload());
    });

});

gulp.task('default', ['watch', 'serve']);

gulp.task('copy', function () {
    gulpCopyPlugin();
});

function gulpCopyPlugin() {
    return gulp.src([
        './announcement/**/*',
        './assets/**/*',
        './content_filler/**/*',
        './db/**/*',
        './export_options/**/*',
        './languages/**/*',
        './libraries/**/*',
        './lms/**/*',
        './post_type/**/*',
        './settings/**/*',
        './shortcodes/**/*',
        './stm-lms-templates/**/*',
        './masterstudy-lms-learning-management-system.php',
        './gulpfile.js',
        './package.json',
        './readme.txt',
    ], {
        base: 'other'
    }).pipe(gulp.dest('/Users/timmysab/Documents/mamp/LMS_Plugin/masterstudy-lms-learning-management-system/trunk/trunk/'));
}