var gulp = require('gulp'),
    source = require('vinyl-source-stream'),
    tasks = require('gulp-load-plugins')(),
    rimraf = require('rimraf'),
    browserify = require('browserify'),
    streamify = require('gulp-streamify'),
    src = './app/Resources/assets/',
    dist = 'web/',
    nodeFolder = 'node_modules/',
    reactify = require('reactify');

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
        return browserify(
                {
                    entries: [src + 'app.js'],
                    transform: [reactify],
                    debug: true,
                    cache: {}, packageCache: {}, fullPaths: true
                }
            ).bundle()
            .pipe(source('app.js'))
            .pipe(tasks.if(tasks.util.env.dist, streamify(tasks.uglify())))
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
