/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var WizardController = (function () {
        function WizardController($scope, $minute, $ui, $timeout, $http, $sce, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.$sce = $sce;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.project = $scope.projects[0] || $scope.projects.create().attr('data_json', {});
            $scope.data = $scope.project.attr('data_json');
            var mobile = function () { return window.screen.width < 640; };
            var preview = function () {
                $scope.project.save().then(function () {
                    var url = '/members/project/preview/' + _this.$scope.project.attr('project_id');
                    _this.$ui.popupUrl('/preview-popup.html', false, null, { ctrl: _this, wizard: _this.$scope.wizard, data: {} });
                    $timeout(function () { return $('#previewFrame').attr('src', url); }, 100);
                });
            };
            $scope.wizard = {
                steps: [
                    { url: 'idea', icon: 'fa-lightbulb-o', iconText: 'Idea', heading: "What's your video about?" },
                    { url: 'item', icon: 'fa-search', iconText: 'Item type', heading: 'Break your idea into list of items' },
                    { url: 'list', icon: 'fa-list', iconText: 'Items list', heading: 'Specify the items in your list' },
                    { url: 'style', icon: 'fa-paint-brush', iconText: 'Video style', heading: 'Choose a video style' },
                    { url: 'publish', icon: 'fa-play-circle', iconText: 'Publish video', heading: 'Create and publish video' },
                ],
                config: {
                    icons: true,
                    onNext: function () { return _this.$scope.project.save(_this.gettext('Project saved')); },
                    jumps: 'restricted',
                    minHeight: 390,
                    model: this.$scope.project,
                    //hideBackButton: true
                    hasFlash: window['swfobject'] && window['swfobject'].hasFlashPlayerVersion("9.0"),
                    buttons: [
                        {
                            icon: 'fa-question-circle',
                            label: 'Help',
                            click: function () { return window.open('//google.com'); },
                            show: function () { return !mobile(); }
                        },
                        {
                            label: 'Preview',
                            icon: 'fa-eye',
                            click: preview,
                            show: function () { return !mobile() && !!$scope.wizard.config.hasFlash && !!$scope.data.style.theme; }
                        }
                    ]
                }
            };
        }
        return WizardController;
    }());
    App.WizardController = WizardController;
    angular
        .module('WizardApp', ['MinuteFramework', 'MinuteAddons', 'MembersApp', 'AngularWizard', 'AngularSearch', 'AngularMedia', 'gettext', 'AngularImageEditor', 'AngularYouTubeEditor',
        'textToSpeech', 'angularAudio', 'AngularMusic', 'AngularFont'])
        .controller('WizardController', ['$scope', '$minute', '$ui', '$timeout', '$http', '$sce', 'gettext', 'gettextCatalog', WizardController]);
})(App || (App = {}));
