module.exports = function (grunt) {

    grunt.initConfig({
        nggettext_extract: {
            pot: {
                files: {
                    'po/template.pot': [
                        'app/View/**/*.php',
                        'app/View/**/*.js',
                        'vendor/minutephp/**/View/**/*.php',
                        'vendor/minutephp/**/View/**/*.js'
                    ]
                }
            }
        },
        nggettext_compile: {
            all: {
                files: {
                    'public/js/translations.js': ['po/*.po']
                }
            }
        }

    });
    grunt.loadNpmTasks('grunt-angular-gettext');
    grunt.registerTask('default', ['nggettext_extract', 'nggettext_compile']);
};