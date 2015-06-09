module.exports = function( grunt ) {
	// Project configuration.
	grunt.initConfig( {
		// Package
		pkg: grunt.file.readJSON( 'package.json' ),
		
		// PHPLint
		phplint: {
			options: {
				phpArgs: {
					'-lf': null
				}
			},
			all: [ '**/*.php', '!node_modules/**', '!bower_components/**' ]
		},
		
		// Check textdomain errors
		checktextdomain: {
			options:{
				text_domain: 'orbis',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php',
					'!deploy/**',
					'!node_modules/**',
					'!tests/**',
					'!wp-content/**'
				],
				expand: true
			}
		},
		
		// Make POT
		makepot: {
			target: {
				options: {
					domainPath: 'languages',
					type: 'wp-theme',
					updatePoFiles: true,
					exclude: [
						'bower_components/.*',
						'node_modules/.*'
					]
				}
			}
		},

		// PHP Code Sniffer
		phpcs: {
			application: {
				dir: [
					'**/*.php',
					'!node_modules/**'
				],
			},
			options: {
				standard: 'phpcs.ruleset.xml'
			}
		},

		// Copy
		copy: {
			main: {
				files: [
					{ // Bootstrap
						expand: true,
						cwd: 'bower_components/bootstrap/dist/',
						src: [ '**' ],
						dest: 'assets/bootstrap'
					},
				]
			}
		},

		// Sass
		sass: {
			dev: {
				options: {
					sourcemap: 'none',
					style: 'expanded',
					noCache: true,
				},
				files: {
					'assets/orbis/css/orbis.css': 'src/sass/orbis.scss',
				}
			},
		},

		// Concat
		concat: {
			js: {
				src: [ 'src/js/orbis.js' ],
				dest: 'assets/orbis/js/orbis.js'
			}
		},

		// CSS min
		cssmin: {
			combine: {
				files: {
					'assets/orbis/css/orbis.min.css': [ 'assets/orbis/css/orbis.css' ]
				}
			}
		},
		
		// Uglify
		uglify: {
			combine: {
				files: {
					'assets/orbis/js/orbis.min.js': [ 'assets/orbis/js/orbis.js' ]
				}
			}
		},

		// Image min
		imagemin: {
			dynamic: {
				files: [
					{ // Orbis
						expand: true,
						cwd: 'src/images',
						src: [ '**/*.{png,jpg,gif}' ],
						dest: 'assets/orbis/images'
					}
				]
			}
		}
	} );

	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-phpcs' );
	grunt.loadNpmTasks( 'grunt-phplint' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-imagemin' );

	// Default task(s).
	grunt.registerTask( 'default', [ 'phplint', 'copy', 'sass', 'cssmin', 'uglify', 'concat', 'imagemin' ] );
	grunt.registerTask( 'build', [ 'phpcs' ] );
	grunt.registerTask( 'pot', [ 'checktextdomain', 'makepot' ] );
};
