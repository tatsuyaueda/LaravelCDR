var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var paths = {
    'jquery': '/node_modules/jquery',
    'bootstrap': '/node_modules/bootstrap',
    'admin_lte': '/node_modules/admin-lte',
    'datatables': '/node_modules/datatables',
    'datatables_bootstrap': '/node_modules/datatables-bootstrap',
    'datatables_buttons': '/node_modules/datatables-buttons',
    'fontawesome': '/node_modules/font-awesome',
    'bootstrap_daterangepicker': '/node_modules/bootstrap-daterangepicker',
    'jquery_treegrid': '/node_modules/jquery-treegrid',
    'bootbox': '/node_modules/bootbox',
    'moment': '/node_modules/moment',
    'select2': '/node_modules/select2/dist'
}

elixir(function (mix) {
    mix
        .sass([
            'app.scss'
        ])
        // DataTables
        .sass([
            paths.datatables_buttons + '/css/buttons.bootstrap.scss',
        ], 'public/css/app.css', './')
        .styles([
            // Bootstrap
            paths.bootstrap + '/dist/css/bootstrap.min.css',
            // Admin LTE
            paths.admin_lte + '/dist/css/AdminLTE.min.css',
            paths.admin_lte + '/dist/css/alt/AdminLTE-select2.min.css',
            paths.admin_lte + '/dist/css/skins/skin-blue-light.min.css',
            // DateRangePicker
            paths.bootstrap_daterangepicker + '/daterangepicker.css',
            // DataTables
            paths.datatables_bootstrap + '/css/dataTables.bootstrap.min.css',
            // Font Awsome
            paths.fontawesome + '/css/font-awesome.css',
            // jQuery TreeGrid
            paths.jquery_treegrid + '/css/jquery.treegrid.css',
            // Select2
            paths.select2 + '/css/select2.min.css'
        ], 'public/css/app.css', './')
        .scripts([
            // jQuery
            paths.jquery + '/dist/jquery.min.js',
            // Bootstrap
            paths.bootstrap + '/dist/js/bootstrap.min.js',
            // Admin LTE
            paths.admin_lte + '/dist/js/app.min.js',
            // Moment
            paths.moment + '/min/moment.min.js',
            paths.moment + '/locale/ja.js',
            // DateRangePicker
            paths.bootstrap_daterangepicker + '/daterangepicker.js',
            // DataTables
            paths.datatables + '/media/js/jquery.dataTables.min.js',
            paths.datatables_bootstrap + '/js/dataTables.bootstrap.min.js',
            paths.datatables_buttons + '/js/dataTables.buttons.js',
            paths.datatables_buttons + '/js/buttons.bootstrap.js',
            paths.datatables_buttons + '/js/buttons.html5.js',
            // jQuery TreeGrid
            paths.jquery_treegrid + '/js/jquery.treegrid.min.js',
            paths.jquery_treegrid + '/js/jquery.treegrid.bootstrap3.js',
            paths.bootbox + '/bootbox.min.js',
            // Select2
            paths.select2 + '/js/select2.min.js',
            paths.select2 + '/js/i18n/ja.js'
        ], 'public/js/app.js', './')
        .browserify('echo.es6')
        .copy(
            'node_modules/bootstrap/dist/fonts',
            'public/build/fonts'
        ).copy(
            'node_modules/font-awesome/fonts',
            'public/build/fonts'
        ).version(['css/app.css', 'js/app.js', 'js/echo.js']);
});
