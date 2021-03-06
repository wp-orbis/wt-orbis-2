module.exports = function( grunt ) {
	require( 'load-grunt-tasks' )( grunt );

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
			theme_style: {
				files: [
					{ // Theme CSS
						expand: true,
						cwd: 'src/css/',
						src: [ '**' ],
						dest: 'css'
					},
				]
			},
			assets: {
				files: [
					{ // Bootstrap
						expand: true,
						cwd: 'bower_components/bootstrap/dist/',
						src: [ '**' ],
						dest: 'assets/bootstrap'
					},
				]
			},

			deploy: {
				src: [
					'**',
					'!bower.json',
					'!composer.json',
					'!composer.lock',
					'!Gruntfile.js',
					'!package.json',
					'!phpunit.xml',
					'!phpunit.xml.dist',
					'!phpcs.ruleset.xml',
					'!CHANGELOG.md',
					'!README.md',
					'!bower_components/**',
					'!deploy/**',
					'!node_modules/**',
					'!src/**',
					'!trash/**',
				],
				dest: 'deploy/latest',
				expand: true
			},
		},

		// Clean
		clean: {
			deploy: {
				src: [ 'deploy/latest' ]
			},
		},

		// Compress
		compress: {
			deploy: {
				options: {
					archive: 'deploy/archives/<%= pkg.name %>.<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'deploy/latest',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		},

		// Git checkout
		gitcheckout: {
			tag: {
				options: {
					branch: 'tags/<%= pkg.version %>'
				}
			},
			develop: {
				options: {
					branch: 'develop'
				}
			}
		},

		// S3
		aws_s3: {
			options: {
				region: 'eu-central-1'
			},
			deploy: {
				options: {
					bucket: 'downloads.pronamic.eu',
					differential: true
				},
				files: [
					{
						expand: true,
						cwd: 'deploy/archives/',
						src: '<%= pkg.name %>.<%= pkg.version %>.zip',
						dest: 'themes/<%= pkg.name %>/'
					}
				]
			}
		},

		// Compass
		compass: {
			build: {
				options: {
					sassDir: 'src/sass',
					cssDir: 'src/css'
				}
			}
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
					'css/orbis.min.css': [ 'css/orbis.css' ]
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

	// Default task(s).
	grunt.registerTask( 'default', [ 'phplint', 'copy', 'compass', 'cssmin', 'uglify', 'concat', 'imagemin' ] );
	grunt.registerTask( 'build', [] );
	grunt.registerTask( 'pot', [ 'checktextdomain', 'makepot' ] );

	grunt.registerTask( 'deploy', [
		'default',
		'build',
		'clean:deploy',
		'copy:deploy',
		'compress:deploy'
	] );
	
	grunt.registerTask( 's3-deploy', [
		'gitcheckout:tag',
		'deploy',
		'aws_s3:deploy',
		'gitcheckout:develop'
	] );
};
