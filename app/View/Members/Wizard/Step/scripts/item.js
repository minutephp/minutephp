/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ItemController = (function () {
        function ItemController($scope, $minute, $ui, $search, $timeout, $q, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$search = $search;
            this.$timeout = $timeout;
            this.$q = $q;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.extractNumber = function (title) {
                var matches;
                if (matches = (title || '').match(/\b\d\d?\b/g)) {
                    for (var i = 0; i < matches.length; i++) {
                        if ((matches[i] > 0) && (matches[i] <= 20)) {
                            return parseInt(matches[i]);
                        }
                    }
                }
                return null;
            };
            this.isPlural = function (word) {
                return /\w+s$/i.test(word);
            };
            $scope.wizard.nextEnabled = function () { return !!$scope.form.item.count && !!$scope.form.item.type; };
        }
        return ItemController;
    }());
    App.ItemController = ItemController;
    angular.module('WizardApp')
        .controller('itemController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', 'gettext', 'gettextCatalog', ItemController]);
})(App || (App = {}));
