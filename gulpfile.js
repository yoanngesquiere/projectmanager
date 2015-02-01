var gulp = require('gulp'),
    tasks = require('gulp-load-plugins')(),
    rimraf = require('rimraf'),
    src = 'app/Resources/assets/',
    dist = 'web/',
    nodeFolder = 'node_modules/';


gulp.task(
    'clean',
    function (callback) {
        rimraf.sync(dist + 'app.js');
        rimraf.sync(dist + 'css/app.css');
        callback();
    }
);

gulp.task(
    'scripts',
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

gulp.task(
    'fonts',
    function () {
        gulp.src(nodeFolder + '/bootstrap/dist/fonts/*')
            .pipe(gulp.dest(dist + 'fonts/'));
    }
);

gulp.task(
    'stylesheets',
    function () {
        gulp.src(src + 'stylesheets/app.less')
            .pipe(tasks.less())
            .pipe(tasks.if(tasks.util.env.dist, tasks.csso()))
            .pipe(gulp.dest(dist + 'css/'));
    }
);


gulp.task('default', ['clean', 'scripts', 'stylesheets', 'fonts']);
