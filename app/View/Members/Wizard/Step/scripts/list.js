/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ListController = (function () {
        function ListController($scope, $minute, $ui, $search, $media, $preview, $cropper, $youtube, $timeout, $q, $http, $interval, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$search = $search;
            this.$media = $media;
            this.$preview = $preview;
            this.$cropper = $cropper;
            this.$youtube = $youtube;
            this.$timeout = $timeout;
            this.$q = $q;
            this.$http = $http;
            this.$interval = $interval;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.checkIt = function () {
                var hasMedia = false;
                var hasVo = false;
                var preview = null;
                angular.forEach(_this.$scope.project.item.list, function (item) {
                    if (!hasMedia && item.media && item.media.sources) {
                        angular.forEach(item.media.sources, function (source) {
                            hasMedia = hasMedia || !!source.url;
                            if (!preview && /(\.(jpg|jpeg|png|gif))$/i.test(source.url)) {
                                preview = source.url;
                            }
                        });
                    }
                    _this.$scope.project.thumb = preview;
                    hasVo = hasVo || !!(item.voice && item.voice.audio);
                });
                if (!hasMedia && !_this.$scope.wizard.global.listMediaConfirm) {
                    _this.$scope.wizard.global.listMediaConfirm = true;
                    _this.$ui.confirm("<b class=\"hidden-xs\">You haven't added any photos or videos</b><br><br>Adding photos / videos to your video is easy and makes a big difference in quality and viewer engagement!<br/><br/>Would you like to see a small demo?", "Continue anyway <i class=\"fa fa-fw fa-chevron-circle-right\"></i>", "<i class=\"fa fa-fw fa-video-camera\"></i> Yes, Show demo")
                        .then(_this.$scope.wizard.next, function () { return _this.$scope.wizard.help('photos'); });
                }
                else if (!hasVo && !_this.$scope.wizard.global.listVoConfirm) {
                    _this.$ui.confirm("<b class=\"hidden-xs\">You haven't added any voice-over</b><br><br>Voice-overs make your videos more professional and engaging! Adding a voice-over is easy and can be done in one click (you don't even need a Mic).<br/><br/>Would you like to see a small demo?", "Continue anyway <i class=\"fa fa-fw fa-chevron-circle-right\"></i>", "<i class=\"fa fa-fw fa-video-camera\"></i> Yes, Show demo")
                        .then(_this.$scope.wizard.next, function () { return _this.$scope.wizard.help('vo'); });
                }
                else {
                    _this.$scope.wizard.next();
                }
            };
            this.addItem = function () {
                _this.$scope.project.item.list.push({});
            };
            this.removeItem = function (item, index) {
                if (item.special === 'introItem') {
                    _this.$scope.project.settings.showIntro = false;
                }
                else if (item.special === 'goodbyeItem') {
                    _this.$scope.project.settings.showGoodbye = false;
                }
                else {
                    _this.$scope.project.item.list.splice(index, 1);
                }
            };
            this.specialItem = function (name, label, placeholder, defaultValue) {
                return _this.$scope.project.settings[name] = _this.$scope.project.settings[name] || { label: label, placeholder: placeholder, name: _this.ucFirst(defaultValue), special: name, voice: {} };
            };
            this.showMediaPopup = function (item) {
                _this.$ui.popupUrl('/media-popup.html', true, null, { ctrl: _this, item: item, data: {} });
            };
            this.ucFirst = function (string) {
                return (string || '').charAt(0).toUpperCase() + (string || '').slice(1);
            };
            this.asNumber = function (index) {
                var ordinals = ['Zeroth', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth'];
                return ordinals[index] || index;
            };
            this.addMedia = function (item) {
                var promise = _this.$media.popup(item.name);
                promise.then(function (results) {
                    item.media = item.media || { sources: [] };
                    angular.forEach(results, function (result) {
                        if (result && result.hasOwnProperty('src')) {
                            var mediaItem = { url: result.src, thumbnail: result.thumbnail || result.src, captionTitle: _this.truncate(item.name), captionText: _this.truncate(result.title) };
                            mediaItem.type = (/youtube\.com/i.test(result.src) || /(\.mp4)$/.test(result.src)) ? 'video' : 'photo';
                            item.media.sources.push(mediaItem);
                            if (/\.(jpg|png|jpeg|gif|bmp)$/i.test(item.src)) {
                                _this.$scope.project.attr('thumbnail', _this.$scope.project.attr('thumbnail') || item.src);
                            }
                        }
                    });
                });
            };
            this.addText = function (item) {
                item.media.sources.push({ text: item.name, heading: 'heading', type: 'text' });
            };
            this.editMedia = function (item) {
                var type = item.type;
                console.log("item, type: ", item, type);
                if (type == 'photo') {
                    _this.editImage(item);
                }
                else if (type == 'video') {
                    _this.editVideo(item);
                }
                else if (type == 'text') {
                    _this.editText(item);
                }
            };
            this.removeMedia = function (sources, item, data) {
                var index = sources.indexOf(item);
                if (index != -1) {
                    sources.splice(index, 1);
                }
                data.sel = null;
            };
            this.previewMedia = function (type, url) {
                if (type === 'photo') {
                    _this.$preview.lightbox([url]);
                }
                else {
                    window.open(url, '_blank');
                }
            };
            this.editCaption = function (item) {
                _this.$ui.popupUrl('/caption-edit-popup.html', false, null, { ctrl: _this, item: item });
            };
            this.editImage = function (item) {
                var promise = _this.$cropper.edit(item.url);
                promise.then(function (url) { return item.url = url; });
            };
            this.editVideo = function (item) {
                var promise = _this.$youtube.cutVideo(item.url, { startTime: item.startTime || 0, endTime: item.endTime || 20, volume: item.volume || 100 });
                promise.then(function (result) { return angular.extend(item, result); });
            };
            this.editText = function (item) {
                _this.$ui.popupUrl('/text-edit-popup.html', false, null, { ctrl: _this, item: item });
            };
            this.editVo = function (item) {
                _this.$ui.popupUrl('/voice-over-popup.html', false, null, { ctrl: _this, item: item });
            };
            this.suggestVO = function (item) {
                item.voice = item.voice || {};
                if (item.special) {
                    item.voice.text = item.special === 'introItem' ? 'Hi! Here is my video about ' + _this.$scope.project.idea : 'So who do you think should be added to the list? Please comment below';
                    return;
                }
                var index = _this.$scope.project.item.list.indexOf(item) || 0;
                item.voice.text = 'Number ' + (index + 1) + '. ' + item.name + '. ';
                var search = 'wikipedia "' + item.name + '" ' + _this.$scope.project.item.type;
                _this.$search.googleSearch(search).then(function (results) {
                    if (results && results.length > 0) {
                        var result = results[0];
                        var matches = void 0;
                        item.voice.text = result.description.replace(/\W+$/, '.');
                        for (var i = 0; i < Math.min(3, results.length); i++) {
                            if (matches = results[i].url.match(/\.wikipedia\.org\/wiki\/(.*)/i)) {
                                _this.$search.wikiSearch(matches[1], 170).then(function (summary) {
                                    if (summary) {
                                        item.voice.text = summary;
                                    }
                                });
                                break;
                            }
                        }
                    }
                });
            };
            this.truncate = function (str) {
                return (str || '').substr(0, 50);
            };
            $scope.wizard.overrides.next = function () { return _this.checkIt(); };
            $scope.project.item.list = $scope.project.item.list || [];
            if (!$scope.project.item.list.length) {
                for (var i = $scope.project.item.list.length; i < $scope.project.item.count; i++) {
                    this.addItem();
                }
            }
        }
        ;
        return ListController;
    }());
    App.ListController = ListController;
    angular.module('WizardApp')
        .controller('listController', ['$scope', '$minute', '$ui', '$search', '$media', '$preview', '$cropper', '$youtube', '$timeout', '$q', '$http', '$interval', 'gettext', 'gettextCatalog', ListController]);
})(App || (App = {}));
