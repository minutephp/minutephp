<link rel="stylesheet" type="text/css" href="/static/bower_components/angularjs-slider/dist/rzslider.css" />
<link rel="stylesheet" type="text/css" href="/static/bower_components/nya-bootstrap-select/dist/css/nya-bs-select.css" />

<script src="/static/bower_components/minute/src/js/minute-addons.js"></script>
<script src="/static/bower_components/minute/src/js/minute-cookie.js"></script>

<script src="/static/bower_components/angular-search/src/js/angular-search.js"></script>
<script src="/static/bower_components/angular-wizard/src/js/angular-wizard.js"></script>
<script src="/static/bower_components/angular-media/src/js/angular-media.js"></script>

<script src="/static/bower_components/ng-image-cropper/dist/angular-image-cropper.js"></script>
<script src="/static/bower_components/angular-image-editor/src/js/angular-image-editor.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="/static/bower_components/angular-youtube-mb/src/angular-youtube-embed.js"></script>

<script src="/static/bower_components/angularjs-slider/dist/rzslider.min.js"></script>

<script src="/static/bower_components/angular-youtube-editor/src/js/angular-youtube-editor.js"></script>

<script src="/static/bower_components/swfobject/swfobject/src/swfobject.js"></script>
<script src="/static/bower_components/angular-audio/src/js/angular-audio.js"></script>
<script src="/static/bower_components/angular-text-to-speech/src/js/text-to-speech.js"></script>

<script src="/static/bower_components/angular-music/src/js/angular-music.js"></script>

<script src="/static/bower_components/nya-bootstrap-select/dist/js/nya-bs-select.js"></script>
<script src="/static/bower_components/angular-color-picker/src/js/color-picker.js"></script>
<script src="/static/bower_components/angular-font/src/js/angular-font.js"></script>

<div class="content-wrapper ng-cloak" ng-app="WizardApp" ng-controller="WizardController as mainCtrl" ng-init="init()" ng-cloak="">
    <div class="container-fluid">
        <div class="members-content">
            <section class="content-header">
                <h1><span translate="">{{(data.idea.title || 'Create video') | ucfirst}}</span></h1>

                <ol class="breadcrumb">
                    <li><a href="" ng-href="/help"><i class="fa fa-question-circle"></i> <span translate="">Need help?</span></a></li>
                </ol>
            </section>

            <section class="content">
                <angular-wizard ng-model="data" steps="wizard.steps" config="wizard.config"></angular-wizard>
            </section>
        </div>
    </div>

    <script type="text/ng-template" id="/preview-popup.html">
        <div class="box box-youtube">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Instant preview (requires Flash)</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal">
                <div class="box-body">
                    <div ng-show="wizard.config.hasFlash">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" id="previewFrame" style="max-width:854px;max-height:480px;"></iframe>
                        </div>
                    </div>

                    <div ng-show="!wizard.config.hasFlash">
                        <p>Adobe flash 9.0 or newer is required to load instant preview.</p>

                        <p><a href="//www.google.com/search?q=get+flash&btnI=I'm+Feeling+Lucky" class="btn btn-default" target="_blank">Download and Install Flash</a></p>
                    </div>
                </div>

                <div class="box-footer with-border" ng-if="!session.user.trial">
                    <div class="pull-left hidden-xs">
                        <span translate="">This is just a 30 second demo.</span><br />
                        Please <a ng-href="/pricing" target="_blank">upgrade your account</a> to remove the watermark and create the full video.
                    </div>
                    <a ng-href="/pricing" target="_blank" class="btn btn-flat btn-primary pull-right">
                        <i class="fa fa-shopping-cart"></i> <span translate>Upgrade</span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </script>


    <pre>{{data | json}}</pre>
</div>
