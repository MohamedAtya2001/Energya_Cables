const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 .js('resources/js/app.js', 'public/js')
 */
mix.webpackConfig({
   devtool: "source-map"
});

mix.sass('public/layout/css/Home/Home.scss', 'public/layout/css/Home')
   .sass('public/layout/css/Login/Login.scss', 'public/layout/css/Login')
   .sass('public/layout/css/Navbar/Navbar.scss', 'public/layout/css/Navbar')
   .sass('public/layout/css/Register/Register.scss', 'public/layout/css/Register')
   .sass('public/layout/css/Reports/Reports.scss', 'public/layout/css/Reports')
   .sass('public/layout/css/ShowAdmin/ShowAdmin.scss', 'public/layout/css/ShowAdmin')
   .sass('public/layout/css/ShowData/ShowData.scss', 'public/layout/css/ShowData')
   .sass('public/layout/css/ShowEmployee/ShowEmployee.scss', 'public/layout/css/ShowEmployee')
   .sass('public/layout/css/Reports/Printer/Extrusion/PrinterExtrusion.scss', 'public/layout/css/Reports/Printer/Extrusion')
   .sass('public/layout/css/Reports/Printer/Finish/PrinterFinish.scss', 'public/layout/css/Reports/Printer/Finish')
   .sass('public/layout/css/Reports/Printer/Hold/PrinterHold.scss', 'public/layout/css/Reports/Printer/Hold')
   .sass('public/layout/css/Reports/Printer/Rewind/PrinterRewind.scss', 'public/layout/css/Reports/Printer/Rewind')
   .sass('public/layout/css/Reports/Printer/Stranding/PrinterStranding.scss', 'public/layout/css/Reports/Printer/Stranding')
   .sass('public/layout/css/Reports/Printer/Traceability/PrinterTraceability.scss', 'public/layout/css/Reports/Printer/Traceability')
   .sass('public/layout/css/ShowData/Printer/Armouring/PrinterArmouring.scss', 'public/layout/css/ShowData/Printer/Armouring')
   .sass('public/layout/css/ShowData/Printer/Assembly/PrinterAssembly.scss', 'public/layout/css/ShowData/Printer/Assembly')
   .sass('public/layout/css/ShowData/Printer/Bedding/PrinterBedding.scss', 'public/layout/css/ShowData/Printer/Bedding')
   .sass('public/layout/css/ShowData/Printer/Drowing/PrinterDrowing.scss', 'public/layout/css/ShowData/Printer/Drowing')
   .sass('public/layout/css/ShowData/Printer/Insulation/PrinterInsulation.scss', 'public/layout/css/ShowData/Printer/Insulation')
   .sass('public/layout/css/ShowData/Printer/Screen/PrinterScreen.scss', 'public/layout/css/ShowData/Printer/Screen')
   .sass('public/layout/css/ShowData/Printer/Sheathing/PrinterSheathing.scss', 'public/layout/css/ShowData/Printer/Sheathing')
   .sass('public/layout/css/ShowData/Printer/Stranding/PrinterStranding.scss', 'public/layout/css/ShowData/Printer/Stranding')
   .sass('public/layout/css/ShowData/Printer/Taps/PrinterTaps.scss', 'public/layout/css/ShowData/Printer/Taps')
   .sass('public/layout/css/ShowData/Printer/CCVInsulation/PrinterCCVInsulation.scss', 'public/layout/css/ShowData/Printer/CCVInsulation')
   .sass('public/layout/css/ShowData/Printer/Lead/PrinterLead.scss', 'public/layout/css/ShowData/Printer/Lead');

