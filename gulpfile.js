/* global require */
var gulp = require('gulp');
var sass = require('gulp-sass');
var postCss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var imageMin = require('gulp-imagemin');
var cssNano = require('cssnano');
var postCssHtml = require('gulp-html-postcss');
var htmlMin = require('gulp-htmlmin');
var GulpSSH = require('gulp-ssh');

gulp.task('default', ['improve-css']);

gulp.task('css', function() {
    return gulp.src('sass/*.sass')
        .pipe(sass({
            includePaths: ['node_modules/bootstrap-sass/assets/stylesheets']
        })
            .on('error', sass.logError))
        .pipe(gulp.dest('web/css'));
});

gulp.task('improve-css', ['css'], function() {
    return gulp.src('web/css/*.css')
        .pipe(postCss([
            autoprefixer,
            cssNano({safe: true})
        ]))
        .pipe(gulp.dest('web/css'));
});

gulp.task('images', function() {
    return gulp.src('web/img/**/*')
        .pipe(imageMin([
            require('imagemin-jpegoptim')({max: 88})
        ]))
        .pipe(imageMin([
            imageMin.gifsicle(),
            imageMin.jpegtran({progressive: true}),
            imageMin.optipng(),
            imageMin.svgo()
        ]))
        .pipe(gulp.dest('web/img'));
});


gulp.task('compress-components', function() {
    return gulp.src('web/components/*-*.html')
        .pipe(htmlMin({
            removeComments: true,
            preventAttributesEscaping: true,
            collapseWhitespace: true,
            minifyJS: {output: {quote_style: 3}},
            minifyCSS: false,
            conservativeCollapse: true
        }))
        .pipe(postCssHtml([
            autoprefixer,
            cssNano({safe: true})
        ]))
        .pipe(gulp.dest('web/components'));
});

gulp.task('deploy-ignore', function() {
    var fs = require('fs');
    var appendData =
        '.*\n' +
        '.*/\n' +
        '/src/\n' +
        '/router.php\n' +
        '/tests/\n';

    fs.appendFileSync('.deployignore', appendData);
});

gulp.task('publish',
    ['default', 'images', 'compress-components', 'deploy-ignore'],
    function() {
        return gulp.src([
            'web/bower_components/iron-*/*.html',
            'web/bower_components/paper-*/*.html',
            'web/bower_components/google-*/*.html',
            'web/bower_components/gold-*/*.html',
            'web/bower_components/neon-*/*.html',
            'web/bower_components/platinum-*/*.html',
            'web/bower_components/polymer/*.html'
        ], {base: 'web/bower_components'})
            .pipe(htmlMin({
                removeComments: true,
                preventAttributesEscaping: true,
                collapseWhitespace: true,
                minifyJS: true,
                minifyCSS: true,
                conservativeCollapse: true
            }))
            .pipe(gulp.dest('web/bower_components'));
    });

gulp.task('sync-database', function() {
    var config = {
        host: 'fenix-ural.com',
        port: 22,
        username: 'dbsync',
        privateKey: '-----BEGIN RSA PRIVATE KEY-----\n' +
        'MIIEpAIBAAKCAQEA3l8zMhNGxJ6kNNwzRqUx5mJj9nNwd2dU6royyMrcloeIjTB8\n' +
        'LKX7+cMX5nH6zHd8pHTFE9zk2VfQ0wANCWXfcYHMlTiMfstrX8TNLOvKV763UFkZ\n' +
        'Dknmqwu3/Pe85DKL1LWkdwqKTHxSGnwd9eG0jVm5dcvFeFGzaSn9NYsxbzxxfcGv\n' +
        'qdEX5RJSjlQJ0yffYPS5XkjMGpuFvQYtlqdmWANoFEDVPOw7DOh+qi9bljwigVLj\n' +
        '4dznXvymkDNYeaBspZwq7+NFznOyA9GSiNqW6XsAfie6LxAX5rq1db9iKAtqBtvI\n' +
        'yh5m3laauRXaWCVPJQezgK+Gl63N/SU/Bitc9wIDAQABAoIBAESny9yoCu9ls3kG\n' +
        'i2ZCVpe0xPwwRAb5hkQ6XLeVumlXSxecYpo+XP+N9nEVu8MpGPiFfNtXFejsrfKX\n' +
        'T28ZXtVip9Fidi4ni+0zi81Ut1JD9cD+4TeCJY+lvJaDvnQODxILSs3eGTjoIUlA\n' +
        'DNf/aYlCrHnsAfnV77iGWEERyp92zIrYFwD8pg2FC3F2oazDDFaCpcYFClVXeG/W\n' +
        'donryKi9pQ3nEWuE/vLsy3j/E+GcbCizLEcvk6ugfbF9y4I+6Tr1l4qqluG06jK9\n' +
        'RrOe2bPvuum+WDkm5nWMdquNkpVWBkTZ1XfCB7LXakxQ4+blxuwhaVTZbFl4dmWK\n' +
        'po32MMECgYEA9LUnam1f8cLseu75Qs10j8BonTHmrv0U8PzqdluTTIZoIvszy3Wi\n' +
        'YCBWtOK18CPXYDUJIHDOmhNtXqhY7K1emsO0HUjNQvoW9wbOx+6kC7qU21Ofi3hm\n' +
        'zNFdi5nzo6H1IJVHMjClNpH/aWCo/Yt0T2lbFgY3IL3O/fizkvLyFUcCgYEA6KIu\n' +
        '6GHe9HWpiYC16GflWSwchB0QZx/hpxrCyv0A/TGBLyPHO7IalNvFWkRxigFbZkDb\n' +
        '9Q7g3tp/55ld6bwvDQtx9BepXJQxqhB57fDPDyIgsBDvCx4Dgbv6jSAwej4DhDA4\n' +
        'ErH5Va+4a+B4MicH0a5cNL34v+V/+Z3zJrcvEtECgYA5wXfoGqCGgyclbLnQFoXo\n' +
        'V9VZJKn5qyoCJu9/t+VwLljtyLRU1RLZ9UgBsXCXmR4ASwQ4b+eTXfp2WO2EDvdB\n' +
        'N+eO8dvgbv50l1q+vYhibEst6PLDDEvXE6Msi82BVXxxkEoZgnm8A4Fw8atxDDUL\n' +
        'eSZScG0agTIVp1la2ZRhiQKBgQC3VDCBQ7fPkPZVfVBd4Zq1hnTGjJ0Dl/VdmlJO\n' +
        'Y8omvp+exaRZ4Abgrr09YNjVODKOR6jP27TNCwZnPs7qxzmRHybjhM4cPlFRQ4DD\n' +
        'SdXziCKYfg/UBAghckGGfAqYG0zsHI/j88uZgkxk/1XZuDaKQM07Z0aj+7m5vocD\n' +
        'SLNZMQKBgQDDgcIlymtWwIR+A2sYTn5zILU3BPCQWXjoHjjNN2D6drR48LoUAVDL\n' +
        'jueufJmasoFidc9Aq1XhzRtPhuwpnulqmwoqt8Hh/QG7Fhklel2i838/TRz/KzMy\n' +
        'MhAnzJtIeaxad39OIH2EkO2RB+Ht9UgyLuHLloH/nr3pzuZmvEmCeA==\n' +
        '-----END RSA PRIVATE KEY-----'
    };

    var gulpSSH = new GulpSSH({
        ignoreErrors: false,
        sshConfig: config
    });

    return gulpSSH.sftp('read',
        '/var/www/fenix-ural.com/shared/database.sqlite',
        {filePath: 'database.sqlite'}
    ).pipe(gulp.dest('./'));
});
