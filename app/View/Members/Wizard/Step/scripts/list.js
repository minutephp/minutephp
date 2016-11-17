/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ListController = (function () {
        function ListController($scope, $minute, $ui, $search, $timeout, $q, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$search = $search;
            this.$timeout = $timeout;
            this.$q = $q;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.addItem = function () {
                _this.$scope.form.item.list.push({});
            };
            this.removeItem = function (item, index) {
                if (item.special === 'introItem') {
                    _this.$scope.form.settings.showIntro = false;
                }
                else if (item.special === 'goodbyeItem') {
                    _this.$scope.form.settings.showGoodbye = false;
                }
                else {
                    _this.$scope.form.item.list.splice(index, 1);
                }
            };
            this.specialItem = function (name, label, placeholder, defaultValue) {
                return _this.$scope.form.settings[name] = _this.$scope.form.settings[name] || { label: label, placeholder: placeholder, name: _this.ucFirst(defaultValue), special: name, voice: {} };
            };
            this.showMediaPopup = function (item) {
                _this.$ui.popupUrl('/media-popup.html', false, null, { ctrl: _this });
            };
            this.ucFirst = function (string) {
                return (string || '').charAt(0).toUpperCase() + (string || '').slice(1);
            };
            this.asNumber = function (index) {
                var ordinals = ['Zeroth', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth'];
                return ordinals[index] || index;
            };
            //$scope.wizard.nextEnabled = () => true;
            $scope.form.item.list = $scope.form.item.list || [];
            for (var i = $scope.form.item.list.length; i < $scope.form.item.count; i++) {
                this.addItem();
            }
        }
        return ListController;
    }());
    App.ListController = ListController;
    angular.module('WizardApp')
        .controller('listController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', 'gettext', 'gettextCatalog', ListController]);
})(App || (App = {}));
