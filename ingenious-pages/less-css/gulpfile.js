var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');

if (typeof Object.assign != 'function') {
    Object.assign = function (target, varArgs) {
        'use strict';
        if (target == null) {
            throw new TypeError('Cannot convert undefined or null to object');
        }
        var to = Object(target);
        for (var index = 1; index < arguments.length; index++) {
            var nextSource = arguments[index];

            if (nextSource != null) {
                for (var nextKey in nextSource) {
                    if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                        to[nextKey] = nextSource[nextKey];
                    }
                }
            }
        }
        return to;
    };
}

var paths = {
  less: './*.less',
  main: './main.less',
  css: '../web/bundles/ingenious/css/'
};

gulp.task('less', function () {
  return gulp.src(paths.main)
    .pipe(less({
      paths: [ path.join(__dirname, 'less', 'includes') ]
    }))
    .pipe(gulp.dest(paths.css));
});

gulp.task('watch', function() {
  gulp.watch(paths.less, ['less']);
});

gulp.task('default', gulp.parallel('watch', 'less'));
