/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class StyleController {
        private slideshow: any;

        constructor(public $scope: any, public $minute: any, public $ui: any, public $http: ng.IHttpService, public $timeout: ng.ITimeoutService, public $q: ng.IQService,
                    public $music: any, public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            $scope.wizard.nextEnabled = () => !!$scope.project.style.theme;

            if (!$scope.wizard.global.styles) {
                $http.get('/members/data/styles').then((obj) => this.setStyles(obj.data));
            }

            if (!$scope.wizard.global.resources) {
                $http.get('/members/data/resources').then((obj: any) => $scope.wizard.global.resources = obj.data);
            }

            this.slideshow = $('#styleCarousel');
            this.slideshow.carousel({interval: false});

            $scope.$watch('project.style.theme + wizard.global.styles.length', () => $timeout(this.updateTheme));
        }

        updateTheme = () => {
            if (this.$scope.wizard.global.styles) {
                let style = this.$scope.project.style;
                let index = this.getStyleIndex(style.theme);
                let theme = this.$scope.wizard.global.styles[index];

                if (theme && (!style.preset || (style.theme != style.preset))) {
                    let data = angular.fromJson(theme.data_json);
                    let defaults = {
                        "watermark": {"type": "none"}, "videoText": {"font": "Alien", "size": 100, "color": "#FFFFFF"}, "captionText": {"font": "Atkins"},
                        "hideCountdown": false, "countUp": false, "textFX": "CountdownText", "customVideoFont": true, "customCaptionFont": true, "aston": "AstonFiller", "volume": 75
                    };

                    delete(data.theme);
                    angular.extend(style, defaults, data, {preset: theme.name});
                }

                this.slideshow.carousel(index);
            }
        };

        slideArrow = (dir) => {
            let index = this.getStyleIndex(this.$scope.project.style.theme) + dir;
            let styles = this.$scope.wizard.global.styles;
            this.$scope.project.style.theme = styles[index < 0 ? styles.length - 1 : index % styles.length].name;
        };

        getStyleIndex = (theme) => {
            return this.$scope.wizard.global.styles ? _.findIndex(this.$scope.wizard.global.styles, {name: theme}) || 0 : 0;
        };

        setMusic = () => {
            this.$music.popup('music', this.$scope.project.style.sound).then((obj) => this.$scope.project.style.sound = obj);
        };

        setSfx = () => {
            this.$music.popup('sfx', this.$scope.project.style.sound).then((obj) => this.$scope.project.style.defaultSfx = obj.url);
        };

        setBranding = () => {
            this.$ui.popupUrl('/branding-popup.html', false, null, {ctrl: this, data: {}, project: this.$scope.project});
        };

        customizeTheme = () => {
            this.$ui.popupUrl('/customize-theme-popup.html', false, null, {ctrl: this, project: this.$scope.project, global: this.$scope.wizard.global, data: {tabs: {}}});
        };

        setStyles = (styles) => {
            this.$scope.wizard.global.styles = styles;
            this.$scope.project.style = this.$scope.project.style || {};

            if (!this.$scope.project.style.theme) {
                this.$scope.project.style.theme = this.randomItem(styles).name;
                this.$music.getTracksByCategory('bright').then((tracks) => this.$scope.project.style.sound = this.randomItem(tracks));
            }
        };

        randomItem = function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        };
    }

    angular.module('WizardApp')
        .controller('styleController', ['$scope', '$minute', '$ui', '$http', '$timeout', '$q', '$music', 'gettext', 'gettextCatalog', StyleController]);
}