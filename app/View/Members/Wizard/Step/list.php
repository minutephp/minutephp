<div ng-controller="listController as stepCtrl">
    <form>
        <p class="help-block">
            <span translate="">Please specify the {{project.item.count}} {{project.item.type}}(s) to show in your video</span>
            <small>(<a href="" ng-href="//google.com/search?q={{project.idea.title}}" target="_blank" class="text-muted">click here to do a google search <i
                        class="fa fa-external-link-square"></i></a>)</small>
        </p>

        <div>
            <div ng-if="project.settings.showIntro" ng-init="item = stepCtrl.specialItem('introItem', 'Video Intro', 'Text for intro item', project.idea.title)">
                <div class="list-group-item list-group-item-bar-none" ng-include="'list-item'"></div>
            </div>

            <div ng-repeat="item in project.item.list">
                <div class="list-group-item list-group-item-bar-none list-group-item-bar-sortable" ng-include="'list-item'" ng-initz="!$index && stepCtrl.editVo(item)"></div>
            </div>

            <div ng-if="project.settings.showGoodbye" ng-init="item = stepCtrl.specialItem('goodbyeItem', 'Video Goodbye', 'Text for goodbye', 'Thanks for watching')">
                <div class="list-group-item list-group-item-bar-none" ng-include="'list-item'"></div>
            </div>
        </div>

        <div style="padding-left:20px;">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="dropup">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" ng-click="stepCtrl.addItem()">
                                <span class="hidden-xs"><i class="fa fa-plus-circle"></i> <span class="text-bold" translate="">Add another {{project.item.type}}</span></span>
                                <span class="text-bold visible-xs" translate="">Add</span>
                            </button>

                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="" ng-click="project.settings.showIntro = !project.settings.showIntro">
                                        <i class="fa fa-fw fa-{{project.settings.showIntro && 'check-square-o' || 'square-o'}}"></i> <span translate="">Add a video Intro item</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" ng-click="project.settings.showGoodbye = !project.settings.showGoodbye">
                                        <i class="fa fa-fw fa-{{project.settings.showGoodbye && 'check-square-o' || 'square-o'}}"></i> <span translate="">Add a video Goodbye item</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

    </form>

    <script type="text/ng-template" id="list-item">
        <div class="form-group">
            <label class="col-sm-3 control-label">{{item.label || (stepCtrl.asNumber($index+1) + ' ' + project.item.type)}}:</label>

            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-11">
                        <input type="text" class="form-control" placeholder="Name / title for {{stepCtrl.asNumber($index+1) | lowercase}} {{project.item.type}}" ng-model="item.name" ng-required="true"
                               ng-class="{'auto-focus': !$index}">
                        <div class="help-block">
                            <div class="pull-right">
                                <span class="text-sm hidden-xs">Add:</span>
                                <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="stepCtrl.showMediaPopup(item)" tooltip="Add photos or videos to this item">
                                    <i class="fa fa-fw {{item.media.sources.length && 'fa-check text-success' || 'fa-camera'}}"></i> Photos / Videos
                                </button>
                                <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="stepCtrl.editVo(item)" tooltip="Add audio commentary to this item">
                                    <i class="fa fa-fw {{item.voice.audio && 'fa-check text-success' || 'fa-volume-up'}}"></i> Voice-over
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-1" ng-if="project.item.list.length > 1 || item.special">
                        <a ng-click="stepCtrl.removeItem(item, $index)" tooltip="remove this item" href="">&times;</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </script>

    <script type="text/ng-template" id="/media-popup.html">
        <div class="box box-lg">
            <div class="box-header with-border">
                <b class="pull-left hidden-xs"><span translate="">Add photo / videos / text to </span> {{(item.name || 'item') | truncate:50}}</b>
                <b class="pull-left visible-xs"><span translate="">Add photo / videos</b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <div class="box-body">
                <div class="pre-scrollable preview">
                    <div class="col-sm-6 col-md-4 col-lg-3 media-block item" ng-repeat="item in item.media.sources">
                        <div class="thumbnail" ng-class="{'alert alert-warning': data.sel === item}" ng-switch="item.type === 'text'" style="padding: 5px; position: relative">
                            <span style="position: absolute; left: 5px; opacity: 0.5" ng-show="item.type == 'video'"><i class="fa fa-play-circle-o fa-2x"></i></span>

                            <div class="fixed-height padded" ng-switch-when="true" ng-click="data.sel = data.sel !== item && item || null">
                                <div class="alert alert-info" ng-dblclick="ctrl.editMedia(item)">
                                    <h3 style="margin:0">{{item.text | truncate: 10}}</h3>
                                    <small>{{item.heading | truncate:20}}</small>
                                </div>
                            </div>

                            <img ng-src="{{item.type === 'photo' && item.url || item.thumbnail}}" class="fixed-height" ng-dblclick="ctrl.previewMedia(item.type, item.url)" ng-switch-default=""
                                 ng-click="data.sel = data.sel !== item && item || null" width="100%" alt="thumbnail">

                            <div class="truncated text-small"><a class="text-muted" href="" ng-click="ctrl.editCaption(item)">{{item.captionText || item.captionTitle || 'Add caption'}}</a></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 item" ng-click="addMedia()">
                        <div class="thumbnail media-add-button text-center">
                            <a href="" ng-click="ctrl.addMedia(item)">
                                <i class="fa fa-plus fa-3x"></i>
                            </a>
                            <small class="text-sm">Add photo / video</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer with-border">
                <ng-switch on="!!data.sel">
                    <div class="pull-left" ng-switch-when="true">
                        <button type="button" class="btn btn-flat btn-info btn-sm" ng-click="ctrl.editMedia(data.sel)">
                            <i class="fa fa-edit"></i> <span class="hidden-xs" translate="">Edit {{data.sel.type}}..</span>
                        </button>
                        <button type="button" class="btn btn-flat btn-info btn-sm" ng-click="ctrl.editCaption(data.sel)">
                            <i class="fa fa-font"></i> <span class="hidden-xs" translate="">Edit Caption</span>
                        </button>
                        <span class="text-muted">|</span>
                        <button type="button" class="btn btn-flat btn-danger btn-sm" ng-click="ctrl.removeMedia(item.media.sources, data.sel, data)">
                            <i class="fa fa-trash"></i> <span class="hidden-xs" translate="">Remove</span>
                        </button>
                    </div>
                    <div class="pull-left" ng-switch-default="">
                        <button type="button" class="btn btn-flat btn-success btn-sm" ng-click="ctrl.addMedia(item)">
                            <i class="fa fa-picture-o"></i> <span class="hidden-xs" translate="">Add photo / video</span>
                        </button>
                        <button type="button" class="btn btn-flat btn-default btn-sm" ng-click="ctrl.addText(item)">
                            <i class="fa fa-font"></i> <span class="hidden-xs" translate="">Add text</span>
                        </button>
                    </div>
                </ng-switch>
                <button type="button" class="btn btn-flat btn-primary text-bold pull-right close-button">
                    <i class="fa fa-check-circle"></i> <span translate>Save</span>
                </button>
            </div>
        </div>
    </script>

    <script type="text/ng-template" id="/caption-edit-popup.html">
        <div class="box box-md">
            <form class="form-horizontal" name="textForm" ng-submit="hide()">
                <div class="box-header with-border">
                    <b class="pull-left"><span translate="">Edit item caption</span></b>
                    <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                    <div class="clearfix"></div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Caption text:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Enter Caption text" ng-model="item.captionText" ng-required="false">
                            <p class="help-block"><span translate="">A small text to describe this photo / video like "PGA Tour 2013"</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Caption title:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Enter Caption title" ng-model="item.captionTitle" ng-required="false">
                            <p class="help-block"><span translate="">A word shown above caption like "Courtesy ESPN", "For more info", etc</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Sound effect:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block">
                                <minute-uploader ng-model="item.sfx" type="audio" preview="true" remove="true" label="Upload sound effect (mp3).."></minute-uploader>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right">
                        <i class="fa fa-check-circle"></i> <span translate>Update caption</span>
                    </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="/text-edit-popup.html">
        <div class="box">
            <form class="form-horizontal" name="textForm" ng-submit="hide()">
                <div class="box-header with-border">
                    <b class="pull-left"><span translate="">Edit text item</span></b>
                    <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                    <div class="clearfix"></div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="title"><span translate="">Title:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" placeholder="Enter Title" ng-model="item.text" ng-required="false">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subTitle"><span translate="">Sub-Title:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="subTitle" placeholder="Enter SubTitle" ng-model="item.heading" ng-required="false">
                        </div>
                    </div>

                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right">
                        <i class="fa fa-check-circle"></i> <span translate>Save text</span>
                    </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="/voice-over-popup.html">
        <div class="box box-md">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Voice-over for {{item.name || 'item'}}</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form>
                <div class="box-body">
                    <div class="form-group">
                        <label>Text for voice-over:</label>

                        <div class="pull-right" ng-show="item.name"><a href="" ng-click="ctrl.suggestVO(item)"><i class="fa fa-lightbulb-o" ng-class="{'animated bounce':!item.voice.text}"></i>
                                Suggest text?</a></div>
                        <textarea class="form-control" ng-model="item.voice.text" id="voice" rows="3" cols="80" ng-init="item.voice.text || ctrl.suggestVO(item)"
                                  placeholder='Voice-over text to record for {{item.name}} (click "Suggest text" to automatically generate a sample)'></textarea>

                        <p class="help-block text-small">Enter any text you would like to record about {{item.name}}. You can either record it in your own voice (click the "Mic"
                            button) or use
                            a computer generated voice-over (click the Text to Speech button).</p>
                    </div>

                    <div class="form-group">
                        <label>Recording options:</label>

                        <div class="help-block">
                            <div class="pull-right">
                                <a href="" class="text-muted" ng-show="item.voice.audio" ng-click="item.voice.audio = null">
                                    <i class="fa fa-trash" title="remove voice-over"></i>
                                </a>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default" ng-class="{active: item.voice.recorder === 'mic'}" ng-click="item.voice.recorder = 'mic'">
                                    <i class="fa fa-microphone"></i> Record my own voice (Mic)
                                </button>
                                <button type="button" class="btn btn-default" ng-class="{active: item.voice.recorder !== 'mic'}" ng-click="item.voice.recorder = 'tts'">
                                    <i class="fa fa-file-audio-o"></i> Use a computer voice (TTS)
                                </button>
                            </div>
                        </div>
                    </div>

                    <ng-switch on="item.voice.recorder === 'mic'">
                        <div audio-recorder ng-model="item.voice.audio" ng-switch-when="true"></div>

                        <div text-to-speech ng-model="item.voice.audio" text="{{item.voice.text}}" ng-switch-default=""></div>
                    </ng-switch>
                </div>

                <div class="box-footer with-border">
                    <button type="button" class="btn btn-flat btn-primary pull-right" ng-disabled="!item.voice.audio" ng-click="hide()">
                        <i class="fa fa-check-circle"></i> <span translate>Save voice-over</span>
                    </button>
                </div>

            </form>
        </div>
    </script>

</div>