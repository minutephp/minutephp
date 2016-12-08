/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class PublishController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $search: any, public $timeout: ng.ITimeoutService, public $q: ng.IQService,
                    public $http: ng.IHttpService, public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            let register = {
                title: 'Publish video',
                msg: 'Your video is being produced. We will notify you via e-mail, as soon as it is ready! (usually takes about 5 minutes)',
                label: 'Enter your email address to receive video:',
                placeholder: 'Your e-mail address (video will be sent here)',
                cta: 'Send me the video link',
                //loginDisabled: true,
            };

            $scope.wizard.nextEnabled = () => !!$scope.project.publish.count && !!$scope.project.publish.type;
            $scope.data = {};

            $scope.session.checkRegistration(register).then(this.renderVideo);
        }

        renderVideo = () => {
            this.$scope.data.status = 'queue';
            this.$scope.data.failMsg = '';

            this.$http.post('/members/queue-video/' + this.$scope.wizard.config.model.attr('project_id'), {}).then(
                (pass) => this.$scope.data.status = 'pass',
                (error) => {
                    this.$scope.data.status = 'fail';
                    this.$scope.data.failMsg = error.data;
                }
            );
        }
    }

    angular.module('WizardApp')
        .controller('publishController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', '$http', 'gettext', 'gettextCatalog', PublishController]);
}