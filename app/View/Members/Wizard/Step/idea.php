<div ng-controller="ideaController as stepCtrl">
    <form ng-init="form.idea.type = form.idea.type || 'keyword'; form.idea.keyword = form.idea.keyword || 'golf'">
        <p class="help-block">
            <span translate="">Type a video "keyword" to generate ideas for your viral video!</span>
        </p>

        <div class="form-group">
            <div class="alert-box" ng-class="{'alert-selected': form.idea.type == 'keyword'}">
                <div class="radio">
                    <label>
                        <input type="radio" ng-model="form.idea.type" value="keyword">
                        <span ng-class="{'text-bold': form.idea.type == 'keyword'}" translate="">Generate video ideas based on my keyword (recommended)</span>
                    </label>
                </div>
                <div class="left-padded" ng-if="form.idea.type == 'keyword'">
                    <div class="row">
                        <div class="col-sm-9">
                            <input type="text" class="form-control auto-focus" id="keyword" placeholder='Enter any keyword like "weight loss", "golf", "movies", "games", "forex", etc'
                                   ng-model="form.idea.keyword" ng-required="true">
                            <p class="help-block"><span translate="">Type a keyword and then click "Generate ideas" button to generate ideas for your video!</span></p>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-flat btn-primary" ng-click="stepCtrl.ideaPopup()" ng-disabled="!form.idea.keyword"
                                    ng-class="{'text-bold': form.idea.type == 'keyword'}">
                                <i class="fa fa-lightbulb-o"></i> <span translate="">Generate ideas..</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="alert-box" ng-class="{'alert-selected': form.idea.type == 'manual'}">
                <div class="radio">
                    <label>
                        <input type="radio" ng-model="form.idea.type" value="manual">
                        <span ng-class="{'text-bold': form.idea.type == 'manual'}" translate="">I want to directly enter my own video idea</span>
                    </label>
                </div>
                <div class="left-padded" ng-if="form.idea.type == 'manual'">
                    <input type="text" class="form-control auto-focus" id="manualIdea"
                           placeholder="Enter a video idea that can be turned into a list of items. E.g. 3 funniest movies, 5 best golfers.."
                           ng-model="form.idea.title" ng-required="true" minlength="3">
                    <p class="help-block">
                        <span translate="">Only input ideas that can be turned into a list of items, e.g. 3 epic fails, most amazing tv shows, etc</span>
                        <a href="" tooltip="Learn more.." class="text-muted" tutorial="/help/good-ideas"><i class="fa fa-question-circle"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </form>

    <script type="text/ng-template" id="/generate-ideas-popup.html">
        <div class="box box-lg">
            <div class="box-header with-border">
                <b class="pull-left"><span translate=""><span translate="">Ideas for keyword</span> {{idea.keyword}}</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <div class="body-body" ng-if="data.loading">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%">Generating {{more&&'more'||''}} ideas..</div>
                </div>
            </div>
            <div class="body-body" ng-if="!data.loading && !data.count">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-exclamation-triangle"></i> <span translate="">Your search term is too narrow and did not generate any ideas.</span>
                </div>

                <p><b><span translate="">For best results:</span></b></p>

                <ol class="padded-list">
                    <li><span translate="">Select a broader search term.</span><br />&nbsp;&nbsp;&nbsp;
                        <i>Example:</i> <span translate="">"golf" instead of "golf swing", "golf courses", or "golf injuries"</span>
                    </li>
                    <li><span translate="">Make sure you're not using any adjectives in your search term.</span><br />&nbsp;&nbsp;&nbsp;
                        <i>Example:</i> <span translate="">"movies" instead of "good movies", "worst movies" or "funny movies"</span>
                    </li>
                    <li><span translate="">Try using your niche as your keyword.</span><br />&nbsp;&nbsp;&nbsp;
                        <i>Example:</i> <span translate="">"video marketing" instead of "video submission software", "video creation software", "video maker"</span>
                    </li>
                </ol>

                <p>&nbsp;</p>

                <p align="center">
                    <button type="button" class="btn btn-primary" ng-click="ctrl.close()"><i class="fa fa-edit"></i> <span translate="">Change keyword</span></button>
                </p>
            </div>

            <div class="body-body" ng-if="!data.loading && !!data.count">
                <br>

                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info"></i> <span translate="">Remember to only choose an idea that can be turned into a list of items!</span>
                    <a href="" tooltip="Learn more.." class="text-muted" tutorial="/help/good-ideas"><i class="fa fa-question-circle"></i></a>
                </div>

                <div class="tabs-panel" ng-init="data.tabs = {}">
                    <ul class="nav nav-tabs">
                        <li ng-class="{active: category === data.tabs.selectedCategory}" ng-repeat="category in data.categories"
                            ng-init="data.tabs.selectedCategory = data.tabs.selectedCategory || category" ng-show="!!category.ideas.length">
                            <a href="" ng-click="data.tabs.selectedCategory = category">{{category.name | ucfirst}} <span translate="">ideas</span></a>
                        </li>
                        <li ng-show="!data.more"><a href="" ng-click="ctrl.generateIdeas(true)"><b>More</b> ideas..</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" ng-repeat="category in data.categories" ng-if="category === data.tabs.selectedCategory">
                            <div class="pre-scrollable">
                                <div class="radio" ng-repeat="result in ::category.ideas | orderBy:ctrl.ideaScore" ng-mouseenter="hover=true" ng-mouseleave="hover=false">
                                    <label>
                                        <input type="radio" ng-model="idea.title" name="idea" ng-value="result">
                                        {{result | ucfirst}}
                                    </label>
                                </div>
                                <div class="radio" ng-show="!$index">
                                    <label><a href="" ng-click="ctrl.editIdea()"><span translate="">Click here to type your own idea!</span></a></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer with-border" ng-if="!data.loading && !!data.count">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-flat btn-primary" ng-disabled="!idea.title" ng-click="ctrl.selectIdea()">
                        <i class="fa fa-check-circle"></i> <span translate>Use selected idea</span>
                    </button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" ng-disabled="!idea.title"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="" ng-click="ctrl.editIdea()"><span translate="">Edit selected idea..</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </script>

</div>