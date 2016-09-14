var config         = require('../config')
if(!config.tasks.css) return

var gulp           = require('gulp')
//var browserSync    = require('browser-sync')
var sass           = require('gulp-sass')
var sourcemaps     = require('gulp-sourcemaps')
var handleErrors   = require('../lib/handleErrors')
var autoprefixer   = require('gulp-autoprefixer')
var path           = require('path')
var minifycss      = require('gulp-minify-css')
var rename         = require('gulp-rename')
var header         = require('gulp-header')
var gulpif         = require('gulp-if')
var headerComment  = require('../lib/getHeaderComment')

var paths = {
  src: path.join(config.root.src, config.tasks.css.src, '/**/*.{' + config.tasks.css.extensions + '}'),
  dest: path.join(config.root.dest, config.tasks.css.dest)
}

var cssTask = function () {
  return gulp.src(paths.src)
    .pipe(sass(config.tasks.css.sass))
    .on('error', handleErrors)
    .pipe(autoprefixer(config.tasks.css.autoprefixer))
    .on('error', handleErrors)
    .pipe(header(headerComment()))
    .pipe(gulp.dest(paths.dest))
   // .pipe(browserSync.stream())
    .pipe(gulpif(process.env.NODE_ENV !== 'dev', minifycss()))
    .on('error', handleErrors)
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(gulp.dest(paths.dest))
}

gulp.task('css', cssTask)
module.exports = cssTask
