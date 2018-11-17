let gulp  = require("gulp");
let babel = require("gulp-babel");
let sass  = require('gulp-sass');

gulp.task("app-js", function () {
    return gulp.src("src/view/js/*.js")
        .pipe(babel())
        .pipe(gulp.dest("web/assets/js/"))
    ;
});

gulp.task("utils-js", function () {
    return gulp.src("src/view/js/utils/*.js")
        .pipe(babel())
        .pipe(gulp.dest("web/assets/js/utils/"))
    ;
});

gulp.task('app-css', function(){
  return gulp.src('src/view/sass/app.scss')
        .pipe(sass())
        .pipe(gulp.dest('web/assets/css/'))
});

gulp.task('default', gulp.series('utils-js', 'app-js', 'app-css'));
