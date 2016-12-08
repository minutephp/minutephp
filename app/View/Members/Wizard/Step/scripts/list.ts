/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ListController {
        private superNext: any;

        constructor(public $scope: any, public $minute: any, public $ui: any, public $search: any, public $media: any, public $preview: any, public $cropper: any, public $youtube: any,
                    public $timeout: ng.ITimeoutService, public $q: ng.IQService, public $http: ng.IHttpService, public $interval: ng.IIntervalService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            $scope.wizard.overrides.next = () => this.checkIt();
            $scope.project.item.list = $scope.project.item.list || [];

            if (!$scope.project.item.list.length) {
                for (let i = $scope.project.item.list.length; i < $scope.project.item.count; i++) {
                    this.addItem();
                }
            }
        };

        checkIt = () => {
            let hasMedia = false;
            let hasVo = false;
            let preview = null;

            angular.forEach(this.$scope.project.item.list, (item) => {
                if (!hasMedia && item.media && item.media.sources) {
                    angular.forEach(item.media.sources, function (source) {
                        hasMedia = hasMedia || !!source.url;

                        if (!preview && /(\.(jpg|jpeg|png|gif))$/i.test(source.url)) {
                            preview = source.url;
                        }
                    });
                }

                this.$scope.project.thumb = preview;
                hasVo = hasVo || !!(item.voice && item.voice.audio);
            });

            if (!hasMedia && !this.$scope.wizard.global.listMediaConfirm) {
                this.$scope.wizard.global.listMediaConfirm = true;
                this.$ui.confirm(`<b class="hidden-xs">You haven't added any photos or videos</b><br><br>Adding photos / videos to your video is easy and makes a big difference in quality and viewer engagement!<br/><br/>Would you like to see a small demo?`,
                    `Continue anyway <i class="fa fa-fw fa-chevron-circle-right"></i>`, `<i class="fa fa-fw fa-video-camera"></i> Yes, Show demo`)
                    .then(this.$scope.wizard.next, () => this.$scope.wizard.help('photos'));
            } else if (!hasVo && !this.$scope.wizard.global.listVoConfirm) {
                this.$ui.confirm(`<b class="hidden-xs">You haven't added any voice-over</b><br><br>Voice-overs make your videos more professional and engaging! Adding a voice-over is easy and can be done in one click (you don't even need a Mic).<br/><br/>Would you like to see a small demo?`,
                    `Continue anyway <i class="fa fa-fw fa-chevron-circle-right"></i>`, `<i class="fa fa-fw fa-video-camera"></i> Yes, Show demo`)
                    .then(this.$scope.wizard.next, () => this.$scope.wizard.help('vo'));
            } else {
                this.$scope.wizard.next();
            }
        };

        addItem = () => {
            this.$scope.project.item.list.push({});
        };

        removeItem = (item, index) => {
            if (item.special === 'introItem') {
                this.$scope.project.settings.showIntro = false;
            } else if (item.special === 'goodbyeItem') {
                this.$scope.project.settings.showGoodbye = false;
            } else {
                this.$scope.project.item.list.splice(index, 1);
            }
        };

        specialItem = (name, label, placeholder, defaultValue) => {
            return this.$scope.project.settings[name] = this.$scope.project.settings[name] || {label: label, placeholder: placeholder, name: this.ucFirst(defaultValue), special: name, voice: {}};
        };

        showMediaPopup = (item) => {
            this.$ui.popupUrl('/media-popup.html', true, null, {ctrl: this, item: item, data: {}});
        };

        ucFirst = (string) => {
            return (string || '').charAt(0).toUpperCase() + (string || '').slice(1);
        };

        asNumber = (index) => {
            let ordinals = ['Zeroth', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth'];
            return ordinals[index] || index;
        };

        addMedia = (item) => {
            let promise = this.$media.popup(item.name);
            promise.then((results) => {
                item.media = item.media || {sources: []};

                angular.forEach(results, (result) => {
                    if (result && result.hasOwnProperty('src')) {
                        let mediaItem: any = {url: result.src, thumbnail: result.thumbnail || result.src, captionTitle: this.truncate(item.name), captionText: this.truncate(result.title)};
                        mediaItem.type = (/youtube\.com/i.test(result.src) || /(\.mp4)$/.test(result.src)) ? 'video' : 'photo';
                        item.media.sources.push(mediaItem);

                        if (/\.(jpg|png|jpeg|gif|bmp)$/i.test(item.src)) {
                            this.$scope.project.attr('thumbnail', this.$scope.project.attr('thumbnail') || item.src);
                        }
                    }
                });
            });
        };

        addText = (item) => {
            item.media.sources.push({text: item.name, heading: 'heading', type: 'text'});
        };

        editMedia = (item) => {
            let type = item.type;
            console.log("item, type: ", item, type);

            if (type == 'photo') {
                this.editImage(item);
            } else if (type == 'video') {
                this.editVideo(item);
            } else if (type == 'text') {
                this.editText(item);
            }
        };

        removeMedia = (sources, item, data) => {
            let index = sources.indexOf(item);
            if (index != -1) {
                sources.splice(index, 1);
            }

            data.sel = null;
        };

        previewMedia = (type, url) => {
            if (type === 'photo') {
                this.$preview.lightbox([url]);
            } else {
                window.open(url, '_blank');
            }
        };

        editCaption = (item) => {
            this.$ui.popupUrl('/caption-edit-popup.html', false, null, {ctrl: this, item: item});
        };

        editImage = (item) => {
            let promise = this.$cropper.edit(item.url);
            promise.then((url) => item.url = url);
        };

        editVideo = (item) => {
            let promise = this.$youtube.cutVideo(item.url, {startTime: item.startTime || 0, endTime: item.endTime || 20, volume: item.volume || 100});
            promise.then((result) => angular.extend(item, result));
        };

        editText = (item) => {
            this.$ui.popupUrl('/text-edit-popup.html', false, null, {ctrl: this, item: item});
        };

        editVo = (item) => {
            this.$ui.popupUrl('/voice-over-popup.html', false, null, {ctrl: this, item: item});
        };

        suggestVO = (item) => {
            item.voice = item.voice || {};

            if (item.special) {
                item.voice.text = item.special === 'introItem' ? 'Hi! Here is my video about ' + this.$scope.project.idea : 'So who do you think should be added to the list? Please comment below';
                return;
            }

            let index = this.$scope.project.item.list.indexOf(item) || 0;
            item.voice.text = 'Number ' + (index + 1) + '. ' + item.name + '. ';

            let search = 'wikipedia "' + item.name + '" ' + this.$scope.project.item.type;

            this.$search.googleSearch(search).then((results) => {
                if (results && results.length > 0) {
                    let result = results[0];
                    let matches;

                    item.voice.text = result.description.replace(/\W+$/, '.');

                    for (let i = 0; i < Math.min(3, results.length); i++) {
                        if (matches = results[i].url.match(/\.wikipedia\.org\/wiki\/(.*)/i)) {
                            this.$search.wikiSearch(matches[1], 170).then((summary) => {
                                if (summary) {
                                    item.voice.text = summary;
                                }
                            });

                            break;
                        }
                    }
                }
            })
        };

        truncate = (str) => {
            return (str || '').substr(0, 50);
        }
    }

    angular.module('WizardApp')
        .controller('listController', ['$scope', '$minute', '$ui', '$search', '$media', '$preview', '$cropper', '$youtube', '$timeout', '$q', '$http', '$interval', 'gettext', 'gettextCatalog', ListController]);
}