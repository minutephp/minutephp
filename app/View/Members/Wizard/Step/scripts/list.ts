/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $search: any, public $timeout: ng.ITimeoutService, public $q: ng.IQService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            //$scope.wizard.nextEnabled = () => true;
            $scope.form.item.list = $scope.form.item.list || [];

            for (let i = $scope.form.item.list.length; i < $scope.form.item.count; i++) {
                this.addItem();
            }
        }

        addItem = () => {
            this.$scope.form.item.list.push({});
        };

        removeItem = (item, index) => {
            if (item.special === 'introItem') {
                this.$scope.form.settings.showIntro = false;
            } else if (item.special === 'goodbyeItem') {
                this.$scope.form.settings.showGoodbye = false;
            } else {
                this.$scope.form.item.list.splice(index, 1);
            }
        };

        specialItem = (name, label, placeholder, defaultValue) => {
            return this.$scope.form.settings[name] = this.$scope.form.settings[name] || {label: label, placeholder: placeholder, name: this.ucFirst(defaultValue), special: name, voice: {}};
        };

        showMediaPopup = (item) => {
            this.$ui.popupUrl('/media-popup.html', false, null, {ctrl: this});
        };

        ucFirst = (string) => {
            return (string || '').charAt(0).toUpperCase() + (string || '').slice(1);
        };

        asNumber = (index) => {
            let ordinals = ['Zeroth', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth'];
            return ordinals[index] || index;
        };
    }

    angular.module('WizardApp')
        .controller('listController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', 'gettext', 'gettextCatalog', ListController]);
}