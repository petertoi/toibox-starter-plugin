const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const SpritesmithPlugin = require( 'webpack-spritesmith' );
const SVGSpritemapPlugin = require( 'svg-spritemap-webpack-plugin' );
const mix = require( 'laravel-mix' );
require( 'laravel-mix-polyfill' );
require( 'laravel-mix-versionhash' );
require( 'laravel-mix-criticalcss' );

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

const config = require( './resources/build/config' );

const assetsDir = config.paths.assets;
const outputDir = config.paths.output;

const options = {
	extractVueStyles: false,
	processCssUrls: false, // Webpack url() rewriting
	purifyCss: false,
	postCss: [
		require( 'autoprefixer' ),
	],
};

mix
	.options( options )
	.setPublicPath( outputDir )
	.sourceMaps( false )
	.sass( `${ assetsDir }/scss/main.scss`, `${ outputDir }/css/main.css` )
	.criticalCss(
		{
			enabled: mix.inProduction(),
			paths: {
				base: config.devUrl,
				templates: `./${ outputDir }/css/critical/`,
			},
			urls: config.criticalCss.urls,
			options: {
				minify: true,
			},
		},
	)
	.js( `${ assetsDir }/js/main.js`, `${ outputDir }/js/main.js` )
	.polyfill( {
		enabled: true,
		useBuiltIns: 'usage',
		targets: false,
	} )
	// .extract()
	.copy( `${ assetsDir }/fonts/**/*`, `${ outputDir }/fonts` )
	.copy( `${ assetsDir }/img/**/*`, `${ outputDir }/img` )
	.copy( `${ assetsDir }/lang/**/*.mo`, `${ outputDir }/lang` )
	.copy( `${ assetsDir }/svg/**/*`, `${ outputDir }/svg` )
	.copy( `${ assetsDir }/sprites/*`, `${ outputDir }/sprites` )
	.browserSync( {
		proxy: config.devUrl,
		files: config.watch,
	} )
	.webpackConfig( {
		plugins: [
			new CleanWebpackPlugin(),
			new SpritesmithPlugin( {
				src: {
					cwd: `${ assetsDir }/sprites/img/`,
					glob: '**/*.png',
				},
				target: {
					image: `${ assetsDir }/sprites/map.png`,
					css: `${ assetsDir }/scss/common/_sprite.scss`,
				},
				apiOptions: {
					cssImageRef: '../sprites/map.png',
				},
			} ),
			new SVGSpritemapPlugin(
				[ `${ assetsDir }/sprites/svg/**/*.svg` ],
				{
					output: {
						filename: 'sprites/map.svg',
						svgo: {
							plugins: [
								{
									removeAttrs: { attrs: '(stroke|fill)' },
								},
							],
						},
					},
				},
			),
		],
		externals: {
			jquery: 'jQuery',
		},
	} );

if ( mix.inProduction() ) {
	mix.versionHash();
}
