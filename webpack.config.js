var Encore = require("@symfony/webpack-encore");

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath("public/build/")
    // public path used by the web server to access the output path
    .setPublicPath("/build")
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    .copyFiles({
        from:   "./assets/images",
        to: "images/[path][name].[ext]"
    })

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry("js/account_delete_trick_like", "./assets/js/account_delete_trick_like.js")
    .addEntry("js/account_picture", "./assets/js/account_picture.js")
    .addEntry("js/comment_ajax", "./assets/js/comment_ajax.js")
    .addEntry("js/head_trick", "./assets/js/head_trick.js")
    .addEntry("js/load_more_comment", "./assets/js/load_more_comment.js")
    .addEntry("js/load_more_trick", "./assets/js/load_more_trick.js")
    .addEntry("js/modal_delete", "./assets/js/modal_delete.js")
    .addEntry("js/navbar", "./assets/js/navbar.js")
    .addEntry("js/scroll", "./assets/js/scroll.js")
    .addEntry("js/section_title", "./assets/js/section_title.js")
    .addEntry("js/slider", "./assets/js/slider.js")
    .addEntry("js/trick_like", "./assets/js/trick_like.js")
    .addEntry("js/trick_picture", "./assets/js/trick_picture.js")
    .addEntry("js/trick_video", "./assets/js/trick_video.js")
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')
    .addStyleEntry("css/app", "./assets/css/app.css")

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = "usage";
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
