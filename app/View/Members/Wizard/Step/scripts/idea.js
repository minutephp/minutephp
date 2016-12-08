/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var IdeaController = (function () {
        function IdeaController($scope, $minute, $ui, $search, $timeout, $q, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$search = $search;
            this.$timeout = $timeout;
            this.$q = $q;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.ideaPopup = function () {
                _this.$scope.popup = { data: { loading: true } };
                _this.$ui.popupUrl('/generate-ideas-popup.html', false, null, { ctrl: _this, idea: _this.$scope.project.idea, data: _this.$scope.popup.data });
                _this.generateIdeas();
            };
            this.generateIdeas = function (more) {
                if (more === void 0) { more = false; }
                var ideas = { top: ['"top 10" %k%'] };
                if (more) {
                    ideas = {
                        top: ['"top 10" %k%', '"10 top" %k%', '"top 5" %k%', '"10 best" %k%', '"best 10" %k%', '"10 most" %k%', '"5 most" %k%', 'best %k%', '10 perfect %k%', '10 greatest %k%'],
                        negative: ['10 worst %k%', '10 bad %k%', '5 worst %k%', '10 embarrassing %k%', '3 %k% mistakes', '10 %k% myths', '10 ugly %k%'],
                        funny: ['10 funny %k%', '10 stupid %k%', '%k% fails', '10 hilarious %k%', '%k% jokes'],
                        other: ['10 about %k%', '10 things %k%', 'list of %k%']
                    };
                }
                var keyword = _this.$scope.project.idea.keyword;
                var promises = [];
                var seen = {};
                var data = angular.extend(_this.$scope.popup.data, { loading: true, categories: [], count: 0, more: more });
                angular.forEach(ideas, function (items, genre) {
                    angular.forEach(items, function (item) {
                        var term = item.replace(/\%k\%/g, '"' + keyword + '"');
                        var promise = _this.$search.googleSuggest(term);
                        var category = Minute.Utils.findWhere(data.categories, { name: genre });
                        if (!category) {
                            category = { name: genre, ideas: [] };
                            data.categories.push(category);
                        }
                        //console.log("term: ", term);
                        promise.then(function (results) {
                            angular.forEach(results, function (result) {
                                var normalized = $.trim(result.replace(/\d+/g, ''));
                                if (normalized && !seen[normalized]) {
                                    seen[normalized] = true;
                                    category.ideas.push(result.replace(/^10\s+/, '3 ').replace(/\s+10\s+/, ' 3 '));
                                    data.count++;
                                }
                            });
                        });
                        promises.push(promise);
                    });
                });
                _this.$q.all(promises).then(function () {
                    data.loading = false;
                    if (!more && data.count < 3) {
                        _this.generateIdeas(true);
                    }
                    console.log("data: ", data);
                });
            };
            this.close = function () {
                _this.$ui.closePopup();
            };
            this.selectIdea = function () {
                _this.close();
                _this.$scope.wizard.next();
            };
            this.editIdea = function () {
                _this.close();
                _this.$scope.project.idea.type = 'manual';
                _this.$timeout(function () { return $('#manualIdea').focus().select(); }, 500);
            };
            this.ideaScore = function (item) {
                var score = (/^(top|best|worst)\s+(\d+)/i.test(item) ? 1 : /(top|best|worst)\s+(\d+)/i.test(item) ? 2 : /^\d+/i.test(item) ? 3 : /\d+/i.test(item) ? 4 : 100) * item.length;
                return _this.$scope.popup.data.more ? score : 0;
            };
            $scope.wizard.nextEnabled = function () { return !!$scope.project.idea.title; };
            //$timeout(this.ideaPopup);
        }
        return IdeaController;
    }());
    App.IdeaController = IdeaController;
    angular.module('WizardApp')
        .controller('ideaController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', 'gettext', 'gettextCatalog', IdeaController]);
})(App || (App = {}));
