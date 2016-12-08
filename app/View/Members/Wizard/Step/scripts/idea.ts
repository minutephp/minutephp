/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class IdeaController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $search: any, public $timeout: ng.ITimeoutService, public $q: ng.IQService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {
            $scope.wizard.nextEnabled = () => !!$scope.project.idea.title;
            //$timeout(this.ideaPopup);
        }

        ideaPopup = () => {
            this.$scope.popup = {data: {loading: true}};
            this.$ui.popupUrl('/generate-ideas-popup.html', false, null, {ctrl: this, idea: this.$scope.project.idea, data: this.$scope.popup.data});
            this.generateIdeas();
        };

        generateIdeas = (more = false) => {
            var ideas: any = {top: ['"top 10" %k%']};

            if (more) {
                ideas = {
                    top: ['"top 10" %k%', '"10 top" %k%', '"top 5" %k%', '"10 best" %k%', '"best 10" %k%', '"10 most" %k%', '"5 most" %k%', 'best %k%', '10 perfect %k%', '10 greatest %k%'],
                    negative: ['10 worst %k%', '10 bad %k%', '5 worst %k%', '10 embarrassing %k%', '3 %k% mistakes', '10 %k% myths', '10 ugly %k%'],
                    funny: ['10 funny %k%', '10 stupid %k%', '%k% fails', '10 hilarious %k%', '%k% jokes'],
                    other: ['10 about %k%', '10 things %k%', 'list of %k%'],
                };
            }

            var keyword = this.$scope.project.idea.keyword;
            var promises = [];
            var seen = {};
            var data = angular.extend(this.$scope.popup.data, {loading: true, categories: [], count: 0, more: more});

            angular.forEach(ideas, (items, genre) => {
                angular.forEach(items, (item) => {
                    let term = item.replace(/\%k\%/g, '"' + keyword + '"');
                    let promise = this.$search.googleSuggest(term);
                    let category = Minute.Utils.findWhere(data.categories, {name: genre});

                    if (!category) {
                        category = {name: genre, ideas: []};
                        data.categories.push(category);
                    }

                    //console.log("term: ", term);
                    promise.then((results) => {
                        angular.forEach(results, (result) => {
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

            this.$q.all(promises).then(() => {
                data.loading = false;

                if (!more && data.count < 3) {
                    this.generateIdeas(true);
                }

                console.log("data: ", data);
            });
        };

        close = () => {
            this.$ui.closePopup();
        };

        selectIdea = () => {
            this.close();
            this.$scope.wizard.next();
        };

        editIdea = () => {
            this.close();
            this.$scope.project.idea.type = 'manual';
            this.$timeout(() => $('#manualIdea').focus().select(), 500);
        };

        ideaScore = (item) => {
            var score = ( /^(top|best|worst)\s+(\d+)/i.test(item) ? 1 : /(top|best|worst)\s+(\d+)/i.test(item) ? 2 : /^\d+/i.test(item) ? 3 : /\d+/i.test(item) ? 4 : 100 ) * item.length;
            return this.$scope.popup.data.more ? score : 0;
        };
    }

    angular.module('WizardApp')
        .controller('ideaController', ['$scope', '$minute', '$ui', '$search', '$timeout', '$q', 'gettext', 'gettextCatalog', IdeaController]);
}