const { dest, series, src, watch } = require('gulp');
const sass = require('gulp-sass');

exports.js = () => {
    src('node_modules/walkway.js/src/walkway.js')
        .pipe(dest('assets/js'));
};

exports.sass = () => {
    return src('assets/scss/main.scss')
        .pipe(sass({
            compass: false,
            outputStyle: 'compressed'
        }).on('error', console.error))
        .pipe(dest('assets/css'));
};

exports.watch = () => {
    watch('assets/scss/**/*.scss', ['sass']);
};

exports.default = series(exports.sass, exports.js);