<div class="content-wrapper ng-cloak" ng-app="TestApp" ng-controller="TestController as mainCtrl" ng-init="init()" ng-cloak="">

<section class="content debug">
<!-- var dump start -->
<div class="panel panel-default">
    <div class="panel-heading"><b>project</b></div>
    <div class="panel-body">
        <pre class="pre-scrollable">{{project.dump() | json}}</pre>
    </div>
</div>

<!-- var dump end -->
</section>
<div class="well">{{session.view | json}}</div>

</div>

