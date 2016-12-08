<div ng-controller="styleController as stepCtrl">
    <form>

        <div ng-show="wizard.global.styles">
            <div class="row">
                <div class="col-sm-6 col-md-8 col-lg-8 hidden-xs">
                    <div id="styleCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item" ng-class="{active: !$index}" ng-repeat="style in wizard.global.styles">
                                <img src="" ng-src="{{style.thumb}}"" alt="{{style.title}}">
                            </div>
                        </div>

                        <a class="left carousel-control" href="" ng-click="stepCtrl.slideArrow(-1)" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        </a>
                        <a class="right carousel-control" ng-click="stepCtrl.slideArrow(1)" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Theme name:</label>

                        <select class="form-control" ng-model="project.style.theme" ng-required="true" ng-options="style.name as style.title for style in wizard.global.styles"></select>
                    </div>
                    <div class="form-group">
                        <label>Background music:</label>

                        <div class="help-block">

                            <div class="btn-group fixed-width">
                                <button type="button" class="btn btn-default btn-sm" ng-click="stepCtrl.setMusic()">
                                    <i class="fa fa-music fa-fw"></i> Select background music..
                                </button>
                                <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="text-small"><a href="" ng-click="setVolume()"><i class="fa fa-fw"></i> Set background music volume..</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Branding and watermark:</label>

                        <p class="help-block">
                            <button type="button" class="btn btn-default btn-sm fixed-width" ng-click="stepCtrl.setBranding()"><i class="fa fa-diamond fa-fw"></i> Add branding / watermark..</button>
                        </p>
                    </div>
                    <div class="form-group faded">
                        <label>Customize theme:</label>

                        <p class="help-block">
                            <button type="button" class="btn btn-default btn-sm fixed-width" ng-click="stepCtrl.customizeTheme()"><i class="fa fa-paint-brush fa-fw"></i> Customize countdown, font, etc..
                            </button>
                        <p class="help-block text-small">&nbsp;&nbsp;&nbsp;(for expert users only)</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script type="text/ng-template" id="/branding-popup.html">
        <div class="box box-md">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Branding and watermark</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal" ng-submit="hide()" name="brandingForm">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="watermark">Watermark:</label>

                                <div class="col-sm-9" ng-init="project.style.watermark.type=project.style.watermark.type||'none'">
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.type" name="watermark" ng-value="'none'"> No watermark
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.type" name="watermark" ng-value="'text'"> Watermark text
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.type" name="watermark" ng-value="'image'"> Watermark image
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" ng-init="project.style.watermark.placement = project.style.watermark.placement || 'bottom-right'"
                                 ng-if="project.style.watermark.type !== 'none'">
                                <label class="col-sm-3 control-label" for="placement">Placement:</label>

                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.placement" name="placement" ng-value="'top-left'"> Top left
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.placement" name="placement" ng-value="'top-right'"> Top right
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.placement" name="placement" ng-value="'bottom-left'"> Bottom left
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="project.style.watermark.placement" name="placement" ng-value="'bottom-right'"> Bottom right
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" ng-if="project.style.watermark.type === 'text'">
                                <label class="col-sm-3 control-label" for="watermarktext">Watermark text:</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" ng-model="project.style.watermark.text" ng-required="true" id="watermarktext"
                                           placeholder="Type your watermark text here" maxlength="25" />
                                </div>
                            </div>

                            <div class="form-group" ng-if="project.style.watermark.type === 'text'">
                                <label class="col-sm-3 control-label" for="font">Text Style:</label>

                                <div class="col-sm-9">
                                    <div angular-font ng-model="project.style.watermark.watermarkText"></div>
                                </div>
                            </div>

                            <div class="form-group" ng-if="project.style.watermark.type === 'image'">
                                <label class="col-sm-3 control-label" for="image">Upload image:</label>

                                <div class="col-sm-9">
                                    <div upload-button ng-model="project.style.watermark.image" type="image" preview="true"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right" ng-disabled="!brandingForm.$valid">
                        <i class="fa fa-check-circle"></i> <span translate>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="/customize-theme-popup.html">
        <div class="box box-md">
            <form class="form-horizontal" name="themeForm" ng-submit="hide()">
                <div class="box-body">
                    <div class="pull-right"><a href="" class="close-button"><sup tooltip="remove"><i class="fa fa-times"></i></sup></a></div>
                    <div class="tabs-panel">
                        <ul class="nav nav-tabs">
                            <li ng-class="{active: tab === data.tabs.selectedTab}" ng-repeat="tab in ['countdown', 'captions']" ng-init="data.tabs.selectedTab = data.tabs.selectedTab || tab">
                                <a href="" ng-click="data.tabs.selectedTab = tab">{{tab | ucfirst}}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" ng-if="data.tabs.selectedTab === 'countdown'">
                                <div class="row">
                                    <div class="col-md-12 form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="hideCountdown">Show countdown:</label>

                                            <div class="col-sm-9">
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="project.style.hideCountdown" name="hideCountdown" ng-value="false"> Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="project.style.hideCountdown" name="hideCountdown" ng-value="true"> No
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="countUp">Countdown style:</label>

                                            <div class="col-sm-9">
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="project.style.countUp" name="countUp" ng-value="false"> Count down (i.e. from 10 to 1)
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" ng-model="project.style.countUp" name="countUp" ng-value="true"> Count up (i.e. from 1 to 10)
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="textFX">Animation style:</label>

                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="project.style.textFX" name="textFX" ng-options="item.id as item.name for item in global.resources.textFXs">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="caption">Background loop:</label>

                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="project.style.bg" name="bg" ng-options="item.url as item.name for item in global.resources.bgs">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="defaultSfx">Countdown Sound:</label>

                                            <div class="col-sm-9">
                                                <p class="help-block">
                                                    <button type="button" class="btn btn-default btn-xs" ng-click="ctrl.setSfx()">
                                                        <i class="fa fa-bolt"></i> Select sound effect..
                                                    </button>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="font">Countdown font:</label>

                                            <div class="col-sm-6">
                                                <div angular-font ng-model="project.style.videoText" hide-font-size="true"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade in active" ng-if="data.tabs.selectedTab === 'captions'">
                                <div class="row">
                                    <div class="col-md-12 form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="caption">Caption style:</label>

                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="project.style.aston" name="aston" ng-options="item.id as item.name for item in global.resources.astons">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="font">Caption font:</label>

                                            <div class="col-sm-6">
                                                <div angular-font ng-model="project.style.captionText" hide-font-size="true" hide-font-color="true"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right" ng-disabled="!themeForm.$valid">
                        <i class="fa fa-check-circle"></i> <span translate>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </script>


</div>