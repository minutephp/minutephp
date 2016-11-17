/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var WizardController = (function () {
        function WizardController($scope, $minute, $ui, $timeout, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.project = $scope.projects[0] || $scope.projects.create().attr('data_json', {});
            $scope.data = $scope.project.attr('data_json');
            $scope.wizard = {
                steps: [
                    { url: 'idea', icon: 'fa-lightbulb-o', iconText: 'Idea', heading: "What's your video about?" },
                    { url: 'item', icon: 'fa-search', iconText: 'Item type', heading: 'Break your idea into list of items' },
                    { url: 'list', icon: 'fa-list', iconText: 'List of items', heading: 'Specify the items in your list' },
                ],
                options: {
                    icons: true,
                    onNext: function () { return _this.$scope.project.save(_this.gettext('Project saved')); },
                    jumps: 'restricted',
                    minHeight: 390
                }
            };
        }
        return WizardController;
    }());
    App.WizardController = WizardController;
    angular.module('WizardApp', ['MinuteFramework', 'MembersApp', 'AngularWizard', 'AngularSearch', 'gettext'])
        .controller('WizardController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', WizardController]);
})(App || (App = {}));
