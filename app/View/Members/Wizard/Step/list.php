<div ng-controller="listController as stepCtrl">
    <form>
        <p class="help-block">
            <span translate="">Please specify the {{form.item.count}} {{form.item.type}}(s) to show in your video</span>
            <small>(<a href="" ng-href="//google.com/search?q={{form.idea.title}}" target="_blank" class="text-muted">click here to do a google search <i
                        class="fa fa-external-link-square"></i></a>)</small>
        </p>

        <div>
            <div ng-if="form.settings.showIntro" ng-init="item = stepCtrl.specialItem('introItem', 'Video Intro', 'Text for intro item', form.idea.title)">
                <div class="list-group-item list-group-item-bar-none" ng-include="'list-item'"></div>
            </div>

            <div ng-repeat="item in form.item.list">
                <div class="list-group-item list-group-item-bar-none list-group-item-bar-sortable" ng-include="'list-item'" ng-init="!$index && stepCtrl.showMediaPopup(item)"></div>
            </div>

            <div ng-if="form.settings.showGoodbye" ng-init="item = stepCtrl.specialItem('goodbyeItem', 'Video Goodbye', 'Text for goodbye', 'Thanks for watching')">
                <div class="list-group-item list-group-item-bar-none" ng-include="'list-item'"></div>
            </div>
        </div>

        <div style="padding-left:20px;">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="dropup">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" ng-click="stepCtrl.addItem()">
                                <i class="fa fa-plus-circle"></i>
                                <span class="text-bold" translate="">Add another {{form.item.type}}</span>
                            </button>
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="" ng-click="form.settings.showIntro = !form.settings.showIntro">
                                        <i class="fa fa-fw fa-{{form.settings.showIntro && 'check-square-o' || 'square-o'}}"></i> <span translate="">Add a video Intro item</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" ng-click="form.settings.showGoodbye = !form.settings.showGoodbye">
                                        <i class="fa fa-fw fa-{{form.settings.showGoodbye && 'check-square-o' || 'square-o'}}"></i> <span translate="">Add a video Goodbye item</span>
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
            <label class="col-sm-3 control-label">{{item.label || (stepCtrl.asNumber($index+1) + ' ' + form.item.type)}}:</label>

            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-11">
                        <input type="text" class="form-control" placeholder="Name / title for {{stepCtrl.asNumber($index+1) | lowercase}} {{form.item.type}}" ng-model="item.name" ng-required="true"
                               ng-class="{'auto-focus': !$index}">
                        <div class="help-block">
                            <div class="pull-right">
                                <span class="text-sm hidden-xs">Add:</span>
                                <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="stepCtrl.showMediaPopup(item)" tooltip="Add photos or videos to this item">
                                    <i class="fa fa-fw {{item.media.sources.length && 'fa-check text-success' || 'fa-camera'}}"></i> Photos / Videos
                                </button>
                                <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="stepCtrl.showVoicePopup(item)" tooltip="Add audio commentary to this item">
                                    <i class="fa fa-fw {{item.voice.audio && 'fa-check text-success' || 'fa-volume-up'}}"></i> Voice-over
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-1" ng-if="form.item.list.length > 1 || item.special">
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
                <b class="pull-left"><span translate="">Add photo / videos / text to </span> {{(item.name || 'item') | truncate:50}}</b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <div class="box-body">
                <div class="pre-scrollable preview">
                    <div class="col-xs-6 col-sm-4 col-md-3 media-block item" ng-repeat="media in item.medias" ng-include="{{media.type}}-item"></div>

                    <div class="col-xs-6 col-sm-4 col-md-3 item" ng-click="addMedia()">
                        <div class="thumbnail media-add-button text-center">
                            <div class="dropdown">
                                <a href="" title="Add photo / video /text" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-plus fa-3x"></i>
                                    <br /><br />
                                    <span translate="" class="text-sm">Add</span><br>
                                    <span translate="" class="text-sm">photos / videos / text</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="" ng-click="ctrl.addImage(item)"><i class="fa fa-fw fa-picture-o"></i> <span translate="">Add photo / video</span></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="" ng-click="ctrl.addText(item)"><i class="fa fa-fw fa-font"></i> <span translate="">Add simple text</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer with-border">
                <button type="button" class="btn btn-flat btn-primary pull-right" ng-disabled="true">
                    <span translate></span> <i class="fa fa-fw fa-angle-right"></i>
                </button>
            </div>
        </div>
    </script>

</div>