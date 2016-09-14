var pkg     = require('../../package')
var header  = [
    '/*!-----------------------------------------------------------------',
    '  Name: {{pkg.title}} - {{pkg.description}}',
    '  Version: {{pkg.version}}',
    '  Author: {{pkg.author}}',
    '  Website: {{pkg.website}}',
    '  Purchase: {{pkg.purchase}}',
    '  Support: {{pkg.support}}',
    '  License: You must have a valid license purchased only from ThemeForest (the above link) in order to legally use the theme for your project.',
    '  Copyright ' + new Date().getFullYear() + '.',
    '-------------------------------------------------------------------*/',
    ''
].join('\n');

module.exports = function(type) {
    type = type || 'css'

    var string = header

    // change css header comment to html comment
    if(type == 'html') {
        string = string.replace(/\* /g, ' ')
            .replace(/\/\*!-----------------------------------------------------------------/g, '<!--')
            .replace(/-------------------------------------------------------------------\*\//g, '-->')
    }

    // change template to real variables
    return string.replace(/\{\{(.*?)\}\}/g, function($0, $1){
        return eval($1) || ''
    })


    return string
}
