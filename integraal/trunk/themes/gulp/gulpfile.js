/**
 * Déclaration des tâches nécessaire à la compilation du thème
 *
 * La commande « gulp watch » va surveiller tous les changements effectués
 * dans les dossiers /scss et /javascript et lancera les tâches nécessaires.
 *
 * Les 3 tâches principales sont :
 * - gulp css
 * - gulp js
 * - gulp documentation
 *
 * Liste des tâches disponibles : gulp --tasks
 *
**/

// Inclure les dépendances
var
  gulp = require('gulp'),
  plugins = require('gulp-load-plugins')(),
  sass = require('gulp-sass'),
  cssbeautify = require('gulp-cssbeautify'),
  cleanCSS = require('gulp-clean-css'),
  stripCssComments = require('gulp-strip-css-comments'),
  minify = require('gulp-minify'),
  rename = require('gulp-rename'),
  cssBase64 = require('gulp-css-base64'),
  clean = require('gulp-clean'),
  dirSync = require('gulp-directory-sync'),
  replace = require('gulp-replace'),
  shell = require('gulp-shell'),
  //sassdoc = require('sassdoc')
;

/**
 * =============================
 * Les sous-tâches individuelles
 * =============================
 */


// Compiler le SCSS en CSS
gulp.task('sass-compile', function() {
  return gulp.src('./scss/theme.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

// Optimiser la CSS compilée
gulp.task('css-optimize', function() {
  return gulp.src('./css/theme.css')
    // Enlever les commentaires
    .pipe(stripCssComments())
    // Embarquer certaines ressources en base64
    .pipe(cssBase64({
      maxWeightResource: 131072,
      extensionsAllowed: ['.svg']
    }))
    // Formater le code
    .pipe(cssbeautify())
    .pipe(gulp.dest('./css'));
});

// Minifier la CSS compilée
gulp.task('css-minify', function() {
  return gulp.src('./css/theme.css')
    .pipe(cleanCSS({
      compatibility: '*'
    }))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(gulp.dest('./css'));
});

// Synchroniser les ressources entre les dossiers /scss et /css
gulp.task('sync-ressources', function() {
  return gulp.src('./images/*')
    .pipe(dirSync('./scss/images', './css/images', {
      printSummary: true
    }));
});

// Minifier le JS
gulp.task('js-minify', function(done) {
  gulp.src('javascript/*.js')
    .pipe(minify({
        ext: {
            min:'.min.js'
        },
        ignoreFiles: ['*.min.js']
    }))
    .pipe(gulp.dest('./javascript'));
  //done();
});

// Compiler le styleguide css
gulp.task('styleguide', shell.task(
  ['./node_modules/.bin/kss --config kss.json']
));

// Compiler la doc sass
// gulp.task('sassdoc', function () {
//   return gulp.src('scss/**/*.scss')
//     .pipe(sassdoc());
// });

/**
 * ======================
 * Les tâches principales
 * ======================
 */


// Traitement du CSS
gulp.task('css', gulp.series(
  'sync-ressources',
  'sass-compile',
  'css-optimize',
  'css-minify',
));

// Traitement du JS
gulp.task('js', gulp.series(
  'js-minify'
));

// Documentation
gulp.task('documentation', gulp.series(
  'styleguide'
  //'sassdoc'
));

// Importer les polices fontello à partir du fichier de config :
// Mets à jour les polices dans ../fonts et la CSS modules/_icons.scss
// Dans fontello, la police doit s'appeler 'icon'
gulp.task('fontello', function() {
  // importer les fichiers dans un dossier temporaire
  return gulp.src('./scss/fontello-config.json')
    .pipe(plugins.fontello({
      font: 'font',
      css: 'css',
      assetsOnly: true
    }))
    .pipe(gulp.dest('./scss/fontello_tmp'))
  // déplacer et renommer les fichiers utiles
  .pipe(gulp.src('./scss/fontello_tmp/font/icon.woff'))
    .pipe(rename('icons.woff'))
    .pipe(gulp.dest('./fonts/icons'))
  .pipe(gulp.src('./scss/fontello_tmp/font/icon.woff2'))
    .pipe(rename('icons.woff2'))
    .pipe(gulp.dest('./fonts/icons'))
  .pipe(gulp.src('./scss/fontello_tmp/css/icon.css'))
    .pipe(replace('../font', '../fonts/icons'))
    .pipe(replace('icon.', 'icons.'))
    .pipe(replace(/,[^,]+format\('svg'\)/g, ''))
    .pipe(replace(/,[^,]+format\('truetype'\)/g, ''))
    .pipe(replace(/url.*format\('embedded-opentype'\),/g, ''))
    .pipe(replace(/src: url\([^\)]+\);/g, ''))
    .pipe(rename('_icons.scss'))
    .pipe(gulp.dest('./scss/modules'))
  /*
  // supprimer le dossier temporaire
  .pipe(gulp.src('./scss/fontello_tmp', {read: false}))
    .pipe(clean())
  */
  ;
});


/**
 * ==========================
 * Surveiller les changements
 * ==========================
 */


gulp.task('watch', function() {
  // CSS
  gulp.watch('./scss/**/*.scss', gulp.series('css'));
  // JS
  gulp.watch('./javascript/*', gulp.series('js'));
  // Fontello
  gulp.watch('./scss/fontello-config.json', gulp.series('fontello'));
  // Documentation
  //gulp.watch('./scss/**/*.scss', gulp.series('documentation'));
});


/**
 * ================
 * Tâche par défaut
 * ================
 */
gulp.task('default', gulp.series('watch'));