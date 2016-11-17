<script src="/static/bower_components/angular-search/src/js/angular-search.js"></script>
<script src="/static/bower_components/angular-wizard/src/js/angular-wizard.js"></script>

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
                <angular-wizard ng-model="data" steps="wizard.steps" options="wizard.options"></angular-wizard>
            </section>
        </div>
    </div>

    <pre>{{data | json}}</pre>
</div>
