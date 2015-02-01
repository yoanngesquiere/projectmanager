var gulp = require('gulp'),
    tasks = require('gulp-load-plugins')(),
    rimraf = require('rimraf'),
    src = 'app/Resources/assets/',
    dist = 'web/';


gulp.task(
    'clean',
    function (callback) {
        rimraf.sync(dist + 'app.js');
        callback();
    }
);

gulp.task(
    'copy',
    function () {
        gulp.src(src + 'app.js')
            .pipe(tasks.browserify({
                insertGlobals : false,
                transform: ['reactify'],
                extensions: ['.jsx']
            }))
            .pipe(tasks.if(tasks.util.env.dist, tasks.uglify()))
            .pipe(gulp.dest(dist));
    }
);


gulp.task('default', ['clean', 'copy']);