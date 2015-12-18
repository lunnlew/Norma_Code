module.exports = function(grunt) {
//start:Project configuration
grunt.initConfig({
  //reading project metadata
  pkg: grunt.file.readJSON('package-npm.json'),
  watch: {
    configFiles: {
      files: [ 'Gruntfile.js' ],
      options: {
        reload: true
      }
    },
    scripts: {
      files: ['app/js/*.js'],
      tasks: ['qunit','default'],
      options: {
        spawn: false,
      },
    },
  },
    qunit: {
    all: ['app/build/**/*.html'],
    connect: {
    server: {
      options: {
        port: 8000,
        base: '.'
      }
    }
  }
  },
  //合并js文件
  concat: {
    options: {
      separator: ';',
      stripBanners: true,
    },
    build: {
      src: ['app/js/*.js'],
      dest: 'app/build/<%= pkg.name %>.js'
    }
  },
  //Javascript代码验证
  jshint: {
    all: ['Gruntfile.js', 'app/build/<%= pkg.name %>.js', 'app/test/**/*.js']
  },
  //minify source code
  uglify: {
    options: {
      //生成一个文件头注释
      banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */',
   },
   build: {
    src: 'app/build/<%= pkg.name %>.js',
    dest: 'app/dist/<%= pkg.name %>.min.js'
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
  //         dest: 'app/dist/',   // Destination path prefix.
  //         ext: '.min.js',   // Dest filepaths will have this extension.
   //        extDot: 'first'   // Extensions in filenames begin after the first dot
   //      },
   //    ],
  //   },
}
});//end:Project configuration


  // 加载任务插件。
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-contrib-qunit');
   // 被执行的任务列表。
  grunt.registerTask('default', ['concat','jshint','uglify']);
  grunt.registerTask('qunit', ['connect','qunit']);
  
};