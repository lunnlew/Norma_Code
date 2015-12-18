module.exports = function(grunt) {
    // 使用 middleware(中间件)，就必须关闭 LiveReload 的浏览器插件
    var serveStatic = require('serve-static');
    var serveIndex = require('serve-index');
    // LiveReload的默认端口号，你也可以改成你想要的端口号
    var lrPort = 35729;
    var webpath = 'web';
    // 使用connect-livereload模块，生成一个与LiveReload脚本
    // <script src="http://127.0.0.1:35729/livereload.js?snipver=1" type="text/javascript"></script>
    var lrSnippet = require('connect-livereload')({
        port: lrPort
    });
    // 使用 middleware(中间件)，就必须关闭 LiveReload 的浏览器插件
    var lrMiddleware = function(connect, options) {
        return [
            // 把脚本，注入到静态文件中
            lrSnippet,
            // 静态文件服务器的路径 原先写法：connect.static(options.base[0])
            serveStatic(options.base[0]),
            // 启用目录浏览(相当于IIS中的目录浏览) 原先写法：connect.directory(options.base[0])
            serveIndex(options.base[0])
        ];
    };

    //start:Project configuration
    grunt.initConfig({
        //reading project metadata
        pkg: grunt.file.readJSON('package-npm.json'),
        connect: {
            options: {
                // 服务器端口号
                port: 8000,
                // 服务器地址(可以使用主机名localhost，也能使用IP)
                hostname: 'localhost',
                livereload: lrPort //声明给 watch 监听的端口
            },
            server: {
                options: {
                    //keepalive: true,
                    open: true,
                    // 物理路径(默认为. 即根目录) 注：使用'.'或'..'为路径的时，可能会返回403 Forbidden. 此时将该值改为相对路径 如：/grunt/reloard。
                    base: webpath,
                }
            }
        },

        watch: {
            configFiles: {
                files: ['Gruntfile.js'],
                options: {
                    reload: true
                }
            },
            livereload: {
                files: [webpath + '/dev/*'],
                options: {
                    livereload: '<%= connect.options.livereload %>',
                }
            },
            script: {
                files: ['Gruntfile.js', webpath + '/dev/*'],
                tasks: ['default', 'test'],
                options: {
                    spawn: false,
                }
            },
        },
        clean: {
            dest: [webpath + '/asserts'],
        },
        copy: {
            main: {
                files: [{
                    expand: true,
                    cwd: webpath + '/dev/',
                    src: ['**/*.html'],
                    dest: webpath,
                    flatten: true,
                    filter: 'isFile'
                }, {
                    expand: true,
                    cwd: webpath + '/dev/',
                    src: ['**/*.js'],
                    dest: webpath + '/asserts/js/',
                    flatten: true,
                    filter: 'isFile'
                }, {
                    expand: true,
                    cwd: webpath + '/dev/',
                    src: ['**/*.css'],
                    dest: webpath + '/asserts/css/',
                    flatten: true,
                    filter: 'isFile'
                }, ],
            },
        },
        qunit: {
            all: [webpath + '/*.html'], //TODO
        },
        //合并js文件
        concat: {
            options: {
                separator: ';',
                stripBanners: true,
            },
            build: {
                src: [webpath + '/asserts/js/*.js'],
                dest: webpath + '/asserts/js/<%= pkg.name %>.js'
            }
        },
        //Javascript代码验证
        jshint: {
            all: ['Gruntfile.js', webpath + '/dev/js/*.js']
        },
        //minify source code
        uglify: {
            options: {
                //生成一个文件头注释
                banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */',
            },
            build: {
                src: webpath + '/asserts/js/<%= pkg.name %>.js',
                dest: webpath + '/asserts/js/<%= pkg.name %>.min.js'
            },
            //   dynamic_mappings: {
            // Grunt will search for "**/*.js" under "lib/" when the "uglify" task
            // runs and build the appropriate src-dest file mappings then, so you
            // don't need to update the Gruntfile when files are added or removed.
            // //       files: [
            //        {
            //         expand: true,     // Enable dynamic expansion.
            //         cwd: 'app/build/',      // Src matches are relative to this path.
            //         src: ['**/*.js'], // Actual pattern(s) to match.
            //         dest: 'app/dest/',   // Destination path prefix.
            //         ext: '.min.js',   // Dest filepaths will have this extension.
            //        extDot: 'first'   // Extensions in filenames begin after the first dot
            //      },
            //    ],
            //   },
        }
    }); //end:Project configuration


    // 加载任务插件。
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');

    // 被执行的任务列表。
    grunt.registerTask('serve', ['connect:server', 'watch']);
    grunt.registerTask('default', ['jshint', 'clean', 'copy', 'concat', 'uglify', 'qunit']);
    grunt.registerTask('test', ['qunit']);
};