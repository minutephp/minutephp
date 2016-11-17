/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ItemController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $search: any, public $timeout: ng.ITimeoutService, public $q: ng.IQService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {
            $scope.wizard.nextEnabled = () => !!$scope.form.item.count && !!$scope.form.item.type;
        }

        extractNumber = (title) => {
            let matches;

            if (matches = (title || '').match(/\b\d\d?\b/g)) {
                for (let i = 0; i < matches.length; i++) {
                    if (( matches[i] > 0 ) && (matches[i] <= 20)) {
                        return parseInt(matches[i]);
                    }
                }
            }

            return null;
        };

        isPlural = (word) => {
            return /\w+s$/i.test(word);
        };
    }

    angular.module('WizardApp')
        .controller('itemController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', 'gettext', 'gettextCatalog', ItemController]);
}