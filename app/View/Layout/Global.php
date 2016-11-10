<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />

    <title></title>
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="/favicon.ico">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="/static/bower_components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="/static/bower_components/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/static/bower_components/minute/src/css/minute.css" />
    <link rel="stylesheet" href="/static/bower_components/alertifyjs/src/css/alertify.css" />

    <script src="/static/bower_components/jquery/dist/jquery.js"></script>
    <script src="/static/bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/static/bower_components/angular/angular.js"></script>

    <script src="/static/bower_components/es6-promise/es6-promise.js"></script>
    <script src="/static/bower_components/angular-gettext/dist/angular-gettext.js"></script>
    <script src="/static/bower_components/angular-http-auth/src/http-auth-interceptor.js"></script>
    <script src="/static/bower_components/alertifyjs/dist/js/alertify.js"></script>

    <script src="/static/bower_components/emitter/index.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-utils.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-core.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-delegator.js"></script>

    <script src="/static/bower_components/minute/src/js/minute-config.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-session.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-ui.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-importer.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-framework.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-directives.js"></script>
    <script src="/static/bower_components/minute/src/js/minute-filters.js"></script>

    <script src="/static/bower_components/angular-tree-menu/src/js/angular-tree-menu.js"></script>

    <minute-event name="import.session.as.js"></minute-event>
    <minute-event name="import.models.as.js"></minute-event>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <minute-include-content></minute-include-content>
</body>

</html>

<?php printf('<!-- Completed in %s secs -->', microtime(true) - APP_START_TIME); ?>