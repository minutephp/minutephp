/// <reference path="E:/var/Dropbox/projects/buzzvid/public/static/bower_components/minute/_all.d.ts" />

module App {
    export class WizardController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public $http: ng.IHttpService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.project = $scope.projects[0] || $scope.projects.create().attr('data_json', {});
            $scope.data = $scope.project.attr('data_json');

            $scope.wizard = {
                steps: [
                    {url: 'idea', icon: 'fa-lightbulb-o', iconText: 'Idea', heading: "What's your video about?"},
                    {url: 'item', icon: 'fa-search', iconText: 'Item type', heading: 'Break your idea into list of items'},
                    {url: 'list', icon: 'fa-list', iconText: 'List of items', heading: 'Specify the items in your list'},
                ],
                options: {
                    icons: true,
                    onNext: () => this.$scope.project.save(this.gettext('Project saved')),
                    jumps: 'restricted',
                    minHeight: 390,
                    //hideBackButton: true
                }
            };
        }
    }

    angular.module('WizardApp', ['MinuteFramework', 'MembersApp', 'AngularWizard', 'AngularSearch', 'gettext'])
        .controller('WizardController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', WizardController]);
}
