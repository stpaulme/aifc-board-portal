const del = require("del");
const { src, dest, series, parallel, watch } = require("gulp");
const autoprefixer = require("gulp-autoprefixer");
const babel = require("gulp-babel");
const cache = require("gulp-cache");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");
const imagemin = require("gulp-imagemin");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const uglify = require("gulp-uglify");

const paths = {
  dest: "dist",
  css: {
    src: "src/scss/**/*.scss",
    dest: "dist/css",
  },
  img: {
    src: "src/img/*",
    dest: "dist/img",
  },
  js: {
    src: ["src/js/**/*.js"],
    dest: "dist/js",
  },
};
const min_suffix = ".min";

sass.compiler = require("node-sass"); // default compiler

async function clean(cb) {
  await del(paths.dest);

  cb();
}

function css(cb) {
  src(paths.css.src)
    .pipe(
      sass({
        outputStyle: "expanded",
      })
    )
    .on("error", sass.logError)
    .pipe(
      autoprefixer({
        cascade: false,
      })
    )
    .pipe(
      cleanCSS({
        compatibility: "ie8",
      })
    )
    .pipe(concat("spm.css"))
    .pipe(rename({ suffix: min_suffix }))
    .pipe(dest(paths.css.dest));

  cb();
}

function img(cb) {
  src(paths.img.src).pipe(cache(imagemin())).pipe(dest(paths.img.dest));

  cb();
}

function js(cb) {
  src(paths.js.src)
    .pipe(
      babel({
        presets: ["@babel/env"],
      })
    )
    .pipe(concat("spm.js"))
    .pipe(uglify())
    .pipe(rename({ suffix: min_suffix }))
    .pipe(dest(paths.js.dest));

  cb();
}

function watcher(cb) {
  watch(paths.css.src).on("change", series(css));
  watch(paths.js.src).on("change", series(js));

  cb();
}

exports.default = series(clean, parallel(css, img, js), watcher);

exports.build = series(clean, parallel(css, img, js));
