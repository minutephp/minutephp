/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />

module App {
    export class TestController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.hello = 'It works!';
        }
    }

    angular.module('TestApp', ['MinuteFramework', 'gettext'])
        .controller('TestController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TestController]);
}
