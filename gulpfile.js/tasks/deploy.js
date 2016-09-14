var config        = require('../config')
var gulp          = require('gulp')
var open          = require('open')
var os            = require('os')
var package       = require('../../package.json')
var path          = require('path')
var gulpSequence  = require('gulp-sequence')
var changed       = require('gulp-changed')


// copy SCSS folder
var copySCSSfolder = function() {
  var paths = {
    src: [path.join(config.root.src, config.tasks.css.src, '/**/*.scss')],
    dest: path.join(config.root.dest, config.tasks.css.dest_deploy),
  }

  return gulp.src(paths.src)
    .pipe(gulp.dest(paths.dest))
}
gulp.task('copy-scss-folder', copySCSSfolder)


// copy Image Placeholders
var copyPlaceholders = function() {
  var paths = {
    src: path.join(config.root.src, config.tasks.images.src_placeholders, '/**'),
    dest: path.join(config.root.dest, config.tasks.images.dest)
  }

  return gulp.src(paths.src)
    .pipe(gulp.dest(paths.dest))
}
gulp.task('copy-placeholders', copyPlaceholders)


// Deploy
var deployTask = function(cb) {
  process.env.NODE_ENV = process.env.NODE_ENV || 'deploy';
  gulpSequence('production', 'copy-scss-folder', 'copy-placeholders', 'zip', cb)
}

gulp.task('deploy', deployTask)
module.exports = deployTask
