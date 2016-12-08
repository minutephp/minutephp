<div ng-controller="publishController as stepCtrl">
    <form>
        <ng-switch on="data.status">
            <div ng-switch-default="">
                <p class="help-block"><i class="fa fa-spinner fa-spin"></i> <b><span translate="">Queueing your video for rendering. Please wait...</span></b></p>
            </div>

            <div ng-switch-when="fail">
                <p class="help-block"><span translate="">Failed to queue video. Please try again after some time or contact support.</span></p>
                <p class="help-block" ng-bind-html="data.failMsg"></p>
                <hr>
                <p class="help-block"><a class="btn btn-primary" href="" ng-click="stepCtrl.renderVideo()"><i class="fa fa-retweet"></i> Try again..</a></p>
            </div>

            <div ng-switch-when="pass">
                <p class="help-block"><b><span translate="">Your video is now rendering..</span></b></p>

                <p class="help-block"><span translate="">It can take about 5 to 10 minutes to process your video.</span></p>

                <p class="help-block"><span translate="">We will notify you on "{{session.user.email}}" as soon as your video is ready!</span>
                    (<a class="text-sm" ng-href="/members/profile"><span translate="">update email?</span></a>)</p>

                <div ng-show="!!wizard.config.hasFlash">
                    <br>
                    <button type="button" class="btn btn-primary btn-flat" ng-click="wizard.global.showPreview()"><i class="fa fa-eye"></i> Show Instant Preview (Ctrl+P)</button>
                </div>

                <hr>

                <div>
                    <p>In the meantime, you can:</p>

                    <ul class="list-unstyled" style="margin-left:20px">
                        <li>
                            <i class="fa fa-caret-right"></i>
                            <a href="//instathumbs.com/?ref=wizard" target="_blank"><span translate="">Create an attractive looking thumbnail for this video.</span></a>
                        </li>
                        <li>
                            <i class="fa fa-caret-right"></i>
                            <a href="" tutorial="youtube-video-seo/?ref=wizard"><span translate="">Read this step-by-step guide to get 10,000+ views for your video.</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </ng-switch>
    </form>
</div>