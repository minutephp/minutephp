/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />

module App {
    export class WizardController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public $http: ng.IHttpService,
                    public $sce: ng.ISCEService, public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.project = $scope.projects[0] || $scope.projects.create().attr('data_json', {});
            $scope.data = $scope.project.attr('data_json');

            let mobile = () => window.screen.width < 640;
            let preview = () => {
                $scope.project.save().then(() => {
                    let url = '/members/project/preview/' + this.$scope.project.attr('project_id');
                    this.$ui.popupUrl('/preview-popup.html', false, null, {ctrl: this, wizard: this.$scope.wizard, data: {}});
                    $timeout(() => $('#previewFrame').attr('src', url), 100);
                });
            };

            $scope.wizard = {
                steps: [
                    {url: 'idea', icon: 'fa-lightbulb-o', iconText: 'Idea', heading: "What's your video about?"},
                    {url: 'item', icon: 'fa-search', iconText: 'Item type', heading: 'Break your idea into list of items'},
                    {url: 'list', icon: 'fa-list', iconText: 'Items list', heading: 'Specify the items in your list'},
                    {url: 'style', icon: 'fa-paint-brush', iconText: 'Video style', heading: 'Choose a video style'},
                    {url: 'publish', icon: 'fa-play-circle', iconText: 'Publish video', heading: 'Create and publish video'},
                ],
                config: {
                    icons: true,
                    onNext: () => this.$scope.project.save(this.gettext('Project saved')),
                    jumps: 'restricted',
                    minHeight: 390,
                    model: this.$scope.project,
                    //hideBackButton: true
                    hasFlash: window['swfobject'] && window['swfobject'].hasFlashPlayerVersion("9.0"),
                    buttons: [
                        {
                            icon: 'fa-question-circle',
                            label: 'Help',
                            click: () => window.open('//google.com'),
                            show: () => !mobile()
                        },
                        {
                            label: 'Preview',
                            icon: 'fa-eye',
                            click: preview,
                            show: () => !mobile() && !!$scope.wizard.config.hasFlash && !!$scope.data.style.theme,
                        }
                    ]
                }
            };
        }
    }

    angular
        .module('WizardApp', ['MinuteFramework', 'MinuteAddons', 'MembersApp', 'AngularWizard', 'AngularSearch', 'AngularMedia', 'gettext', 'AngularImageEditor', 'AngularYouTubeEditor',
            'textToSpeech', 'angularAudio', 'AngularMusic', 'AngularFont'])
        .controller('WizardController', ['$scope', '$minute', '$ui', '$timeout', '$http', '$sce', 'gettext', 'gettextCatalog', WizardController]);
}
