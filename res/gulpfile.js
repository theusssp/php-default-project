var fs      = require('fs'),
    gulp    = require('gulp'),
    sass    = require('gulp-sass'),
    rename  = require('gulp-rename'),
    cssmin  = require('gulp-cssmin'),
    jshint  = require('gulp-jshint'),
    jsmin   = require('gulp-jsmin'),
    concat  = require('gulp-concat'),
    uglify  = require('gulp-uglify'),
    addsrc  = require('gulp-add-src'),
    watch   = require('gulp-watch'),
    htmlmin = require('gulp-htmlmin'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    imageop = require('gulp-image-optimization');

gulp.task('styles', function() {
    gulp.src('sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('css'));

    gulp.src([
        './css/theme.css', './css/styles.css'
    ])
    .pipe(concat('all.css'))
    .pipe(gulp.dest('./css/'));
});

gulp.task('cssmin', function() {

    if (fs.existsSync('css/all.css')) {
        fs.unlinkSync('css/all.css');
    }

    gulp.src([
        'theme/material/global/css/bootstrap.min.css',
        'theme/material/global/css/bootstrap-extend.min.css',
        'vendors/owl-carousel/owl.carousel.css',
        'theme/assets/css/site.min.css',
        'theme/material/global/vendor/animsition/animsition.css',
        'theme/material/global/vendor/asscrollable/asScrollable.css',
        'theme/material/global/vendor/switchery/switchery.css',
        'theme/material/global/vendor/intro-js/introjs.css',
        'theme/material/global/vendor/slidepanel/slidePanel.css',
        'theme/material/global/vendor/flag-icon-css/flag-icon.css',
        'theme/material/global/vendor/waves/waves.css',
        'theme/material/global/vendor/chartist/chartist.css',
        'theme/material/global/vendor/jvectormap/jquery-jvectormap.css',
        'theme/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css',
        'theme/material/base/assets/examples/css/dashboard/v1.css',
        'theme/material/global/fonts/material-design/material-design.min.css',
        'theme/material/global/fonts/brand-icons/brand-icons.min.css'
    ])
        .pipe(concat('theme.css'))
        .pipe(cssmin({
            keepSpecialComments:0
        }))
        .pipe(gulp.dest('./css/'));

    gulp.src([
        './css/theme.css', './css/styles.css'
    ])
    .pipe(concat('all.css'))
    .pipe(gulp.dest('./css/'));

});

gulp.task('scripts-libs-admin', function() {

    gulp.src([
        //Plugins
        './theme/material/global/vendor/babel-external-helpers/babel-external-helpers.js',
        './theme/material/global/vendor/jquery/jquery.js',
        './theme/material/global/vendor/tether/tether.js',
        './theme/material/global/vendor/bootstrap/bootstrap.js',
        './theme/material/global/vendor/animsition/animsition.js',
        './theme/material/global/vendor/mousewheel/jquery.mousewheel.js',
        './theme/material/global/vendor/asscrollbar/jquery-asScrollbar.js',
        './theme/material/global/vendor/asscrollable/jquery-asScrollable.js',
        './theme/material/global/vendor/ashoverscroll/jquery-asHoverScroll.js',
        './theme/material/global/vendor/waves/waves.js',
        './theme/material/global/vendor/switchery/switchery.min.js',
        './theme/material/global/vendor/intro-js/intro.js',
        './theme/material/global/vendor/screenfull/screenfull.js',
        './theme/material/global/vendor/slidepanel/jquery-slidePanel.js',
        './theme/material/global/vendor/chartist/chartist.min.js',
        './theme/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js',
        './theme/material/global/vendor/jvectormap/jquery-jvectormap.min.js',
        './theme/material/global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js',
        './theme/material/global/vendor/matchheight/jquery.matchHeight-min.js',
        './theme/material/global/vendor/peity/jquery.peity.min.js',
        //Scripts
        './theme/material/global/js/State.js',
        './theme/material/global/js/Component.js',
        './theme/material/global/js/Plugin.js',
        './theme/material/global/js/Base.js',
        './theme/material/global/js/Config.js',
        './theme/material/base/assets/js/Section/Menubar.js',
        './theme/material/base/assets/js/Section/GridMenu.js',
        './theme/material/base/assets/js/Section/Sidebar.js',
        './theme/material/base/assets/js/Section/PageAside.js',
        './theme/material/base/assets/js/Plugin/menu.js',
        './theme/material/global/js/config/colors.js',
        './theme/material/base/assets/js/config/tour.js',
        //Page
        './theme/material/base/assets/js/Site.js',
        './theme/material/global/js/Plugin/asscrollable.js',
        './theme/material/global/js/Plugin/slidepanel.js',
        './theme/material/global/js/Plugin/switchery.js',
        './theme/material/global/js/Plugin/jquery-placeholder.js',
        './theme/material/global/js/Plugin/matchheight.js',
        './theme/material/global/js/Plugin/jvectormap.js',
        './theme/material/global/js/Plugin/peity.js',
        './theme/material/global/js/Plugin/material.js',
        //Others Plugins
        './js/jrangel/jquery.core.js',
        './js/jrangel/jquery.btnload.js',
        './js/jrangel/jquery.btnrest.js',
        './js/jrangel/jquery.store.js',
        './js/jrangel/jquery.combobox.js',
        './js/jrangel/jquery.form.js',
        './js/jrangel/jquery.upload.js',
        './js/jrangel/jquery.table.js',
        './js/jrangel/jquery.arquivos.js',
        './js/jrangel/jquery.panel.js',
        './js/jrangel/jquery.picker.js',
        './js/aribeiro/selecionar.js'
    ])
        .pipe(jshint())
        .pipe(uglify())
        .pipe(jsmin())
        .pipe(concat('./../js/libs.js', {newLine: ';'}))
        .pipe(gulp.dest('js'));

});

gulp.task('scripts', function() {

	gulp.src([
        './scripts/**/*.js'
    ])
		.pipe(jshint())
		.pipe(uglify())
		.pipe(jsmin())
		.pipe(rename({suffix: '.min'}))
        .pipe(concat('./../js/scripts.js', {newLine: ';'}))
		.pipe(gulp.dest('js'));

    gulp.src([
        './js/libs.js', './js/scripts.js'
    ])
    .pipe(concat('all.js'))
    .pipe(gulp.dest('./js/'));

});

gulp.task('html', function() {
    gulp.src('html/*.html')
    .pipe(htmlmin({
    	collapseWhitespace: true,
    	removeComments: true,
    	removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl'));
    
    gulp.src('html/admin/*.html')
    .pipe(htmlmin({
        collapseWhitespace: true,
        removeComments: true,
        removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl/admin'));
});
 
gulp.task('images', function(cb) {
    gulp.src(['images/**/*.png','images/**/*.jpg','images/**/*.gif','images/**/*.jpeg']).pipe(imageop({
        optimizationLevel: 5,
        progressive: true,
        interlaced: true
    })).pipe(gulp.dest('img')).on('end', cb).on('error', cb);
});

gulp.task('default', function() {
    gulp.watch('sass/**/*.scss',['styles']);
	gulp.watch('theme/material/**/*.css',['cssmin']);
    gulp.watch('theme/material/**/*.js',['scripts-libs-admin']);
	gulp.watch('scripts/**/*.js',['scripts']);
    gulp.watch('html/**/*.html',['html']);
	gulp.watch('images_originals/**/*.*',['images']);
});