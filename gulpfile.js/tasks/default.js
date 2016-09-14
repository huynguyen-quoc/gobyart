var gulp            = require('gulp')
var gulpSequence    = require('gulp-sequence')
var getEnabledTasks = require('../lib/getEnabledTasks')

var defaultTask = function(cb) {
  process.env.NODE_ENV = process.env.NODE_ENV || 'dev';
  var tasks = getEnabledTasks('watch')
  gulpSequence('clean', tasks.assetTasks, tasks.codeTasks, 'static-assets', 'static-bower', 'frontend-static-copy-image', 'frontend-static-copy-fonts', cb)
}

gulp.task('default', defaultTask)
module.exports = defaultTask
