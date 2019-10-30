var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
        .setOutputPath('public/build/')
        .setPublicPath('/build')
        .addEntry('js/app', './assets/js/app.js')
        .addStyleEntry('css/app', './assets/css/app.scss')
        .addStyleEntry('css/login', './assets/css/login.scss')
        .splitEntryChunks()
        .enableSingleRuntimeChunk()
        .cleanupOutputBeforeBuild()
        .enableBuildNotifications()
        .enableSourceMaps(!Encore.isProduction())
        .enableVersioning(Encore.isProduction())
        .enableSassLoader()
//        .autoProvideVariables({
//            $: "jquery",
//            jQuery: "jquery"
//        })
        .autoProvidejQuery()
        ;

module.exports = Encore.getWebpackConfig();
