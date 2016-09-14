var config        = require('../config')
if(!config.tasks.zip) return

var pkg           = require('../../package')
var gulp          = require('gulp')
var zip           = require('gulp-zip')
var rename        = require('gulp-rename')
var del           = require('del')
var gulpSequence  = require('gulp-sequence')
var handleErrors  = require('../lib/handleErrors')

var createTempFolder = function() {
    return gulp.src(config.root.dest + '/**/*')
        .pipe(gulp.dest(config.root.dest + '/' + '_' + pkg.name))
}
gulp.task('zip-create-temp-folder', createTempFolder)


var removeTempFolder = function(cb) {
    del([config.root.dest + '/' + '_' + pkg.name]).then(function (paths) {
        cb()
    })
}
gulp.task('zip-remove-temp-folder', removeTempFolder)


var startZip = function() {
    return gulp.src(config.root.dest + '/' + '_' + pkg.name + '/**/*', { base : './' + config.root.dest })
        .pipe(zip('_' + pkg.name + '.zip'))
        .on('error', handleErrors)
        .pipe(gulp.dest(config.root.dest))
}
gulp.task('zip-start', startZip)


var zipTask = function(cb) {
    gulpSequence('zip-create-temp-folder', 'zip-start', 'zip-remove-temp-folder', cb)
}

gulp.task('zip', zipTask)
module.exports = zipTask
