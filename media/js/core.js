/**
 * Inline development version. Only to be used while developing since it uses document.write to load scripts.
 */

/*jshint smarttabs:true, undef:true, latedef:true, curly:true, bitwise:true, camelcase:true */
/*globals $code */

(function (exports) {
    "use strict";

    var html = "", baseDir;

    var scripts = document.getElementsByTagName('script');
    for (var i = 0; i < scripts.length; i++) {
        var src = scripts[i].src;

        if (src.indexOf('/core.js') != -1) {
            baseDir = src.substring(0, src.lastIndexOf('/'));
        }
    }

    function writeScripts() {
        document.write(html);
    }

    function load(path) {

        if (path.indexOf('.js') !== -1) {
            html += '<script type="text/javascript" src="' + baseDir + '/' + path + '"></script>\n';
        }

        if (path.indexOf('.css') !== -1) {
            html += '<link rel="stylesheet" type="text/css" href="' + baseDir + '/' + path + '" />\n';
        }
    }

    load('lib/jce.js');
    load('../../../../../components/com_jce/editor/libraries/js/lib/html5.js');
    load('../../../../../components/com_jce/editor/libraries/js/lib/tips.js');
    load('../../../../../components/com_jce/editor/libraries/js/lib/colorpicker.js');

    writeScripts();
})(this);