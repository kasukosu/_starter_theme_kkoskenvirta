/* require dependencies */

var path = require('path');
var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var fontMagician = require('postcss-font-magician')({
	hosted: ['wp-content/themes/kkoskenvirta_starter/assets/fonts']
})
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');
var image = require('gulp-image');
var uglify = require('gulp-uglify-es').default;
var concat = require('gulp-concat');
var order = require('gulp-order');
var poToMo = require('gulp-potomo-js');
var livereload = require('gulp-livereload');
var babel = require('gulp-babel');
var webp = require('gulp-webp');
var clone = require('gulp-clone');

var clonesink = clone.sink();

var buildPath = {
	theme: path.join(__dirname, '../public/wp-content/themes/kkoskenvirta_starter'),
	muplugins: path.join(__dirname, '../public/wp-content/mu-plugins'),
	plugins: path.join(__dirname, '../public/wp-content/plugins'),
};

var port = 35745;

/* templates */

gulp.task('templates', function() {
	return (
		gulp.src('./src/tpl/**/*')
		.pipe(gulp.dest('./dist/tpl'))
		.pipe(gulp.dest(buildPath.theme))
		.pipe(livereload())
	);
});

gulp.task('watch-templates', function() {
	livereload.listen(port);
	gulp.watch('./src/tpl/**/*', gulp.series('templates'));
});

/* mu-plugins */

gulp.task('mu-plugins', function() {
	return (
		gulp.src('./src/mu-plugins/**/*')
		.pipe(gulp.dest('./dist/mu-plugins'))
		.pipe(gulp.dest(buildPath.muplugins))
	);
});

gulp.task('watch-mu-plugins', function() {
	gulp.watch('./src/mu-plugins/**/*', gulp.series('mu-plugins'));
});

/* plugins */

gulp.task('plugins', function() {
	return (
		gulp.src('./src/plugins/**/*')
		.pipe(gulp.dest('./dist/plugins'))
		.pipe(gulp.dest(buildPath.plugins))
	);
});

gulp.task('watch-plugins', function() {
	gulp.watch('./src/plugins/**/*', gulp.series('plugins'));
});

/* languages */

gulp.task('languages', function() {
	return (
		gulp.src('./src/tpl/languages/*.po')
		.pipe(poToMo())
		.pipe(gulp.dest('./dist/tpl/languages'))
		.pipe(gulp.dest(buildPath.theme + '/languages'))
	);
});

gulp.task('watch-languages', function() {
	gulp.watch('./src/tpl/languages/*.po', gulp.series('languages'));
});

/* styles */

gulp.task('styles', function() {
	var processors = [
		fontMagician,
        autoprefixer,
        cssnano
    ];
	return (
		gulp.src([
			'./src/sass/*.scss',
			'./src/sass/**/*.scss',
			'!./src/sass/**/gutenberg.*.scss',
			'!./src/sass/gutenberg.*.scss',
		])
		.pipe(sass({
			outputStyle: 'compressed'
		}).on('error', sass.logError))
		.pipe(gulp.dest('./dist/assets/css'))
		.pipe(postcss(processors))
		.pipe(gulp.dest(buildPath.theme + '/assets/css'))
		.pipe(livereload())
	);
});

gulp.task('gutenberg-styles', function() {
	var processors = [
		fontMagician,
        autoprefixer,
        cssnano
    ];
	return (
		gulp.src([
			'./src/sass/**/gutenberg.*.scss',
		])
		.pipe(sass({
			outputStyle: 'compressed'
		}).on('error', sass.logError))
		.pipe(postcss(processors))
		.pipe(gulp.dest('./dist/assets/css'))
		.pipe(gulp.dest(buildPath.theme + '/assets/css'))
		.pipe(livereload())
	);
});

gulp.task('watch-styles', function() {
	livereload.listen(port);
	gulp.watch('./src/sass/**/*.scss', gulp.series(['styles', 'gutenberg-styles']));
});

/* scripts */

gulp.task('scripts', function() {
	return (
		gulp.src([
			'./src/js/*.js',
			'!./src/js/gutenberg.*.js',
		])
		.pipe(order([
			'vendor/jquery-*.min.js',
			'vendor/jquery.*.js',
			'vendor/*.min.js',
			'vendor/*.js',
			'*.js',
		]))
		.pipe(concat('site.js'))
		.pipe(gulp.dest('./dist/assets/js'))
		.pipe(uglify())
		.pipe(gulp.dest(buildPath.theme + '/assets/js'))
	);
});

gulp.task('gutenberg-scripts', function() {
	return (
		gulp.src([
			'./src/js/gutenberg.*.js',
		])
		.pipe(babel({
			plugins: ['transform-react-jsx']
		}))
		.pipe(gulp.dest('./dist/assets/js'))
		//.pipe(uglify())
		.pipe(gulp.dest(buildPath.theme + '/assets/js'))
	);
});

gulp.task('watch-scripts', function() {
	gulp.watch('./src/js/*.js', gulp.series(['scripts', 'gutenberg-scripts']));
});

/* images */

gulp.task('images', function() {
	return (
		gulp.src('./src/img/*')
		.pipe(image({
			pngquant: true,
			optipng: false,
			zopflipng: false, //true
			jpegRecompress: false,
			mozjpeg: true,
			guetzli: false,
			gifsicle: true,
			svgo: true,
			concurrent: 10
		}))
		.pipe(clonesink)
		.pipe(webp({
			//quality: 75,
		}))
		.pipe(clonesink.tap())
		.pipe(gulp.dest('./dist/assets/img'))
		.pipe(gulp.dest(buildPath.theme + '/assets/img'))
	);
});

gulp.task('watch-images', function() {
	gulp.watch('./src/img/*', gulp.series('images'));
});

/* fonts */

gulp.task('fonts', function() {
	return (
		gulp.src('./src/fonts/*')
		.pipe(gulp.dest('./dist/assets/fonts'))
		.pipe(gulp.dest(buildPath.theme + '/assets/fonts'))
	);
});

gulp.task('watch-fonts', function() {
	gulp.watch('./src/fonts/*', gulp.series('fonts'));
});

/* videos */

gulp.task('videos', function() {
	return (
		gulp.src('./src/video/*')
		.pipe(gulp.dest('./dist/assets/video'))
		.pipe(gulp.dest(buildPath.theme + '/assets/video'))
	);
});

gulp.task('watch-videos', function() {
	gulp.watch('./src/videos/*', gulp.series('videos'));
});

/* combine */

gulp.task('wp', gulp.parallel('templates', 'mu-plugins', 'plugins', 'languages', 'styles', 'gutenberg-styles', 'scripts', 'gutenberg-scripts', 'images', 'fonts', 'videos'));

gulp.task('watch-wp', gulp.parallel('watch-templates', 'watch-mu-plugins', 'watch-plugins', 'watch-languages', 'watch-styles', 'watch-scripts', 'watch-images', 'watch-fonts', 'watch-videos'));

gulp.task('assets', gulp.parallel('styles', 'scripts', 'images', 'fonts', 'videos'));

gulp.task('watch-assets', gulp.parallel('watch-styles', 'watch-scripts', 'watch-images', 'watch-fonts', 'watch-videos'));
