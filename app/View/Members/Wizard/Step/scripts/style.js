/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var StyleController = (function () {
        function StyleController($scope, $minute, $ui, $http, $timeout, $q, $music, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$http = $http;
            this.$timeout = $timeout;
            this.$q = $q;
            this.$music = $music;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.updateTheme = function () {
                if (_this.$scope.wizard.global.styles) {
                    var style = _this.$scope.project.style;
                    var index = _this.getStyleIndex(style.theme);
                    var theme = _this.$scope.wizard.global.styles[index];
                    if (theme && (!style.preset || (style.theme != style.preset))) {
                        var data = angular.fromJson(theme.data_json);
                        var defaults = {
                            "watermark": { "type": "none" }, "videoText": { "font": "Alien", "size": 100, "color": "#FFFFFF" }, "captionText": { "font": "Atkins" },
                            "hideCountdown": false, "countUp": false, "textFX": "CountdownText", "customVideoFont": true, "customCaptionFont": true, "aston": "AstonFiller", "volume": 75
                        };
                        delete (data.theme);
                        angular.extend(style, defaults, data, { preset: theme.name });
                    }
                    _this.slideshow.carousel(index);
                }
            };
            this.slideArrow = function (dir) {
                var index = _this.getStyleIndex(_this.$scope.project.style.theme) + dir;
                var styles = _this.$scope.wizard.global.styles;
                _this.$scope.project.style.theme = styles[index < 0 ? styles.length - 1 : index % styles.length].name;
            };
            this.getStyleIndex = function (theme) {
                return _this.$scope.wizard.global.styles ? _.findIndex(_this.$scope.wizard.global.styles, { name: theme }) || 0 : 0;
            };
            this.setMusic = function () {
                _this.$music.popup('music', _this.$scope.project.style.sound).then(function (obj) { return _this.$scope.project.style.sound = obj; });
            };
            this.setSfx = function () {
                _this.$music.popup('sfx', _this.$scope.project.style.sound).then(function (obj) { return _this.$scope.project.style.defaultSfx = obj.url; });
            };
            this.setBranding = function () {
                _this.$ui.popupUrl('/branding-popup.html', false, null, { ctrl: _this, data: {}, project: _this.$scope.project });
            };
            this.customizeTheme = function () {
                _this.$ui.popupUrl('/customize-theme-popup.html', false, null, { ctrl: _this, project: _this.$scope.project, global: _this.$scope.wizard.global, data: { tabs: {} } });
            };
            this.setStyles = function (styles) {
                _this.$scope.wizard.global.styles = styles;
                _this.$scope.project.style = _this.$scope.project.style || {};
                if (!_this.$scope.project.style.theme) {
                    _this.$scope.project.style.theme = _this.randomItem(styles).name;
                    _this.$music.getTracksByCategory('bright').then(function (tracks) { return _this.$scope.project.style.sound = _this.randomItem(tracks); });
                }
            };
            this.randomItem = function (arr) {
                return arr[Math.floor(Math.random() * arr.length)];
            };
            $scope.wizard.nextEnabled = function () { return !!$scope.project.style.theme; };
            if (!$scope.wizard.global.styles) {
                $http.get('/members/data/styles').then(function (obj) { return _this.setStyles(obj.data); });
            }
            if (!$scope.wizard.global.resources) {
                $http.get('/members/data/resources').then(function (obj) { return $scope.wizard.global.resources = obj.data; });
            }
            this.slideshow = $('#styleCarousel');
            this.slideshow.carousel({ interval: false });
            $scope.$watch('project.style.theme + wizard.global.styles.length', function () { return $timeout(_this.updateTheme); });
        }
        return StyleController;
    }());
    App.StyleController = StyleController;
    angular.module('WizardApp')
        .controller('styleController', ['$scope', '$minute', '$ui', '$http', '$timeout', '$q', '$music', 'gettext', 'gettextCatalog', StyleController]);
})(App || (App = {}));
