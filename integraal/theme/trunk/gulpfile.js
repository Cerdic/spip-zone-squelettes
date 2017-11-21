/**
 * Déclaration des tâches nécessaire à la compilation du thème
 *
 * La commande « gulp watch » va surveiller tous les changements effectués
 * dans les dossiers /src et /javascript et lancera la compilation
 * et les traitements afférents (minification etc.)
 *
 * Tâches disponibles (gulp --tasks) :
 * - watch :            surveiller les changements dans /scss et /javascript
 * - sass :             compiler le SCSS en CSS
 * - css :              traiter le CSS compilé (formatage, autoprefixer, etc.)
 * - css-minify :       Créer des copies minifiées des CSS
 * - css-sourcemaps :   créer les sourcemaps des CSS
 * - sync :             synchroniser les images et polices
 * - fontello :         importer les fichiers fontello
 * - js-minify :        Créer des copies minifiées des JS
 *
 * [TODO] Traiter le JS
**/

// Inclure les dépendances
var
  gulp = require('gulp'),
  plugins = require('gulp-load-plugins')(),
  sass = require('gulp-sass'),
  postcss = require('gulp-postcss'),
  sourcemaps = require('gulp-sourcemaps'),
  autoprefixer = require('autoprefixer'),
  cssbeautify = require('gulp-cssbeautify'),
  cleanCSS = require('gulp-clean-css'),
  stripCssComments = require('gulp-strip-css-comments'),
  minify = require('gulp-minify'),
  rename = require('gulp-rename'),
  cssBase64 = require('gulp-css-base64'),
  clean = require('gulp-clean'),
  dirSync = require('gulp-directory-sync')
;

// Surveiller certains fichiers et lancer une série de tâches
gulp.task('watch', function() {
  // CSS
  gulp.watch('./scss/**/*', gulp.series(
    //'fontello',
    'sync',
    'sass',
    'css',
    'css-sourcemaps',
    'css-minify'
  ));
  // JS
  gulp.watch('./javascript/*', gulp.series(
    'js-minify'
  ));
});

// Compiler le SASS en CSS
gulp.task('sass', function() {
  return gulp.src('./scss/theme.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

// Traiter le CSS compilé (compatibilité, optimisations...)
gulp.task('css', function() {
  return gulp.src('./css/theme.css')
    // Ajouter les préfixes navigateurs
    .pipe(postcss(
      [autoprefixer()]
    ))
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

// Créer des copies minifiée des CSS
gulp.task('css-minify', function() {
  return gulp.src('./css/theme.css')
    .pipe(cleanCSS({
      compatibility: 'ie9'
    }))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(gulp.dest('./css'));
});

// Créer les sourcemaps des CSS
gulp.task('css-sourcemaps', function() {
  return gulp.src('./css/*.css')
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./css'));
});

// Synchroniser les images
gulp.task('sync', function() {
  return gulp.src('./images/*')
    .pipe(dirSync('./scss/images', './css/images', {
      printSummary: true
    }));
});

// Importer les fichiers fontello à partir du fichier de config
// [FIXME] Il faut ensuite corriger les chemins à la main dans fonts/fontello.scss
gulp.task('fontello', function() {
  // importer les fichiers dans un dossier temporaire
  gulp.src('./scss/fontello-config.json')
    .pipe(plugins.fontello({
      font: 'font',
      css: 'css'
    }))
    .pipe(gulp.dest('./scss/fontello_tmp'));
  // déplacer les fichiers importés
  gulp.src('./scss/fontello_tmp/font/fontello.woff')
    .pipe(gulp.dest('./polices'));
  gulp.src('./scss/fontello_tmp/font/fontello.woff2')
    .pipe(gulp.dest('./polices'));
  gulp.src('./scss/fontello_tmp/css/fontello.css')
    .pipe(rename('_fontello.scss'))
    .pipe(gulp.dest('./scss/modules'));
  // supprimer le dossier temporaire
  gulp.src('./scss/fontello_tmp', {
      read: false
    })
    .pipe(clean());
  done();
});

// Créer des copies minifiée des JS
gulp.task('js-minify', function() {
  gulp.src('javascript/*.js')
    .pipe(minify({
        ext: {
            min:'.min.js'
        },
        ignoreFiles: ['.min.js', '-min.js']
    }))
    .pipe(gulp.dest('./javascript'))
});

// Tâche par défaut = watch
gulp.task('default', gulp.series('watch'));
