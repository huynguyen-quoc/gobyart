var config         = require('../config')
if(!config.tasks.js) return

var gulp           = require('gulp')
//var browserSync    = require('browser-sync')
var handleErrors   = require('../lib/handleErrors')
var path           = require('path')
var gulpif         = require('gulp-if')
var uglify         = require('gulp-uglify')
var rename         = require('gulp-rename')
var header         = require('gulp-header')
var headerComment  = require('../lib/getHeaderComment')

var paths = {
    src: path.join(config.root.src, config.tasks.js.src, '/**/*.js'),
    dest: path.join(config.root.dest, config.tasks.js.dest)
}

var jsTask = function () {
  return gulp.src(paths.src)
    .pipe(header(headerComment()))
    .on('error', handleErrors)
    .pipe(gulp.dest(paths.dest))
    .pipe(gulpif(process.env.NODE_ENV !== 'dev', uglify()))
    .on('error', handleErrors)
    .pipe(rename({
      extname: '.min.js'
    }))
    .pipe(header(headerComment()))
    .pipe(gulp.dest(paths.dest))
    //.pipe(browserSync.stream())
}

gulp.task('js', jsTask)
module.exports = jsTask
