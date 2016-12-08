/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var PublishController = (function () {
        function PublishController($scope, $minute, $ui, $search, $timeout, $q, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$search = $search;
            this.$timeout = $timeout;
            this.$q = $q;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.renderVideo = function () {
                _this.$scope.data.status = 'queue';
                _this.$scope.data.failMsg = '';
                _this.$http.post('/members/queue-video/' + _this.$scope.wizard.config.model.attr('project_id'), {}).then(function (pass) { return _this.$scope.data.status = 'pass'; }, function (error) {
                    _this.$scope.data.status = 'fail';
                    _this.$scope.data.failMsg = error.data;
                });
            };
            var register = {
                title: 'Publish video',
                msg: 'Your video is being produced. We will notify you via e-mail, as soon as it is ready! (usually takes about 5 minutes)',
                label: 'Enter your email address to receive video:',
                placeholder: 'Your e-mail address (video will be sent here)',
                cta: 'Send me the video link'
            };
            $scope.wizard.nextEnabled = function () { return !!$scope.project.publish.count && !!$scope.project.publish.type; };
            $scope.data = {};
            $scope.session.checkRegistration(register).then(this.renderVideo);
        }
        return PublishController;
    }());
    App.PublishController = PublishController;
    angular.module('WizardApp')
        .controller('publishController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', '$http', 'gettext', 'gettextCatalog', PublishController]);
})(App || (App = {}));
