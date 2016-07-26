var browserify = require('browserify');
var babelify = require('babelify');
var gulp = require('gulp');
var cache = require('gulp-cached');
var phpcbf = require('gulp-phpcbf');
var prettify = require('gulp-jsbeautifier');
var less = require('gulp-less');
var concat = require('gulp-concat');
var strictify = require('strictify');
var source = require('vinyl-source-stream');
var watchify = require('gulp-watchify');
var through2 = require('through2');

var assets_dir = './resources/assets/';

var vendor_js_files = [
    assets_dir + "js/vendor/jquery.min.js",
    assets_dir + "js/vendor/angular.min.js",
    assets_dir + "js/vendor/bootstrap.min.js",
    assets_dir + "js/vendor/unveil.js",
    assets_dir + "js/vendor/ng-resource.min.js",
    assets_dir + "js/vendor/ng-table.js",
    assets_dir + "js/vendor/ng-infinite-scroll.js"
];


// js files
var angular_js_files = [
    assets_dir + 'js/angular.js',
    // assets_dir + 'js/factories/*.js',
    // assets_dir + 'js/controllers/*.js'
];

var jsbeautifier_options = {
    mode: 'VERIFY_AND_WRITE',
    js: {
        maxPreserveNewlines: 2
    }
};

// php files for php conesniffer
var php_files = [
    'app/**/*.php',
    'config/**/*.php'
];

//PHPcbf options
var phpcbf_options = {
    bin: 'vendor/bin/phpcbf',
    standard: 'PSR2',
    warningSeverity: 0
};

var watch_config = {
    less: assets_dir + 'less/**/*.less',
    jsbeautify: [assets_dir + 'js/**/*.js', '!' + assets_dir + 'js/{vendor,vendor/**}'],
    scripts: assets_dir + 'js/**/*.js',
    phpcbf_app: php_files[0],
    phpcbf_config: php_files[1]
};


// Gulp task definitions
gulp.task('jsbeautify', function() {
    return gulp.src(watch_config.jsbeautify)
        .pipe(prettify(jsbeautifier_options))
        .pipe(gulp.dest(assets_dir + 'js/'));
});

gulp.task('less', function() {
    return gulp.src([assets_dir + 'less/app.less'])
        .pipe(less())
        .pipe(gulp.dest('./public/css'));
});

gulp.task('vendor-scripts', function() {
    return gulp.src(vendor_js_files)
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('scripts', ['jsbeautify'], function() {
    return gulp.src(assets_dir + 'js/app.js')
        .pipe(cache('scripts'))
        .pipe(through2.obj(function(file, enc, next) {
            browserify(file.path, { debug: true })
                .transform(strictify)
                .transform(babelify)
                .bundle(function(err, res) {
                    if (err) { return next(err); }

                    file.contents = res;
                    next(null, file);
                });
        }))
        .on('error', function(error) {
            console.log(error.stack);
            this.emit('end');
        })
        .pipe(gulp.dest('./public/js'));
});

gulp.task('angular', function() {
    return gulp.src(angular_js_files)
        .pipe(concat('angular.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('phpcbf-app', function() {
    return gulp.src(php_files[0])
        .pipe(cache('phpcbf_app'))
        .pipe(phpcbf(phpcbf_options))
        .pipe(gulp.dest('app'));
});

gulp.task('phpcbf-config', function() {
    return gulp.src(php_files[1])
        .pipe(cache('phpcbf_config'))
        .pipe(phpcbf(phpcbf_options))
        .pipe(gulp.dest('config'));
});

gulp.task('js', [
    'scripts', 'angular', 'vendor-scripts'
]);

gulp.task('default', [
    'less',
    'vendor-scripts',
    'angular',
    'scripts'
]);

gulp.task('all',[
    'less',
    'vendor-scripts',
    'angular',
    'scripts',
    'phpcbf-app',
    'phpcbf-config'
]);

gulp.task('watch', function() {
    gulp.watch(watch_config.less, ['less']);
    gulp.watch(watch_config.scripts, { debounceDelay: 1000 }, ['scripts']);
    gulp.watch(watch_config.angular, { debounceDelay: 1000 }, ['angular']);
    // gulp.watch(watch_config.phpcbf_app, { debounceDelay: 7000 }, ['phpcbf_app']);
    // gulp.watch(watch_config.phpcbf_config, { debounceDelay: 7000 }, ['phpcbf_config']);
});

