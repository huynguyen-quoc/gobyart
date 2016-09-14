var config  = require('../config')
var changed = require('gulp-changed')
var gulp    = require('gulp')
var path    = require('path')

var paths = {
  src: path.join(config.root.src, config.tasks.staticbower.src, '/**'),
  dest: path.join(config.root.staticdest, config.tasks.staticbower.dest)
}

var staticTask = function() {
  return gulp.src(paths.src)
    .pipe(changed(paths.dest)) // Ignore unchanged files
    .pipe(gulp.dest(paths.dest))
}

gulp.task('static-bower', staticTask)
module.exports = staticTask
