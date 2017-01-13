/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var TestController = (function () {
        function TestController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.hello = 'It works!';
        }
        return TestController;
    }());
    App.TestController = TestController;
    angular.module('TestApp', ['MinuteFramework', 'gettext'])
        .controller('TestController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TestController]);
})(App || (App = {}));
