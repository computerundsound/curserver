<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="{$standards.application_root_HTTP}"/>

    <link rel="shortcut icon" href="/favicon.ico">

    {if isset($javaScriptVariables)}

        {foreach  key=key item=value from=$javaScriptVariables}
            <meta name="javascriptVariables" content="javaScriptVariables" data-name="{$key}" data-value="{$value}">
        {/foreach}

    {/if}

    <title>{$sitetitle}</title>
    <link rel="stylesheet" href="inc/assets/bower_components/font-awesome/css/font-awesome.css">

    <!-- Bootstrap-CSS -->
    <link href="inc/assets/css/main.css" rel="stylesheet">

</head>

<body>

<div id="top_impressum_short">
    Jörg Wrase &copy; 2016 - www.cusp.de
</div>

<div class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Navigation ein-/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{$standards.project_name}</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="http://localhost/phpmyadmin/" target="_blank">
                        <i class="fa fa-database" aria-hidden="true"></i> PHPmyAdmin
                    </a>
                </li>
                <li>
                    <a href="?action=phpinfo" target="_blank">
                        <i class="fa fa-server" aria-hidden="true"></i> PHPinfo
                    </a>
                </li>
                <li>
                    <a href="http://www.CUS-production.com" target="_blank">
                        <i class="fa fa-external-link" aria-hidden="true"></i> www.CUS-production.com
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-10 col-lg-offset-1">

            <div class="clearfix">
                <p>
                    <button class="btn btn-warning hostmask_db_curserver_backup">Make Backup From curserver-DB</button>
                    <button class="btn btn-warning hostmask_db_all_backup">Make Backup From all DBs</button>
                </p>
            </div>

            <h1 class="page-header">XAMPP VHost Manager for Windows</h1>

            {block name=content}Content{/block}

        </div>
    </div>
</div>

<!-- Bootstrap-JavaScript
================================================== -->
<!-- Am Ende des Dokuments platziert, damit Seiten schneller laden -->

<!-- build:js -->
<script type="text/javascript" src="inc/assets/bower_components/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="inc/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script type="text/javascript" src="inc/assets/bower_components/bootbox.js/bootbox.js"></script>
<script type="text/javascript" src="inc/assets/bower_components/mustache.js/mustache.js"></script>
<script type="text/javascript" src="inc/assets/js/_main.js"></script>
<script type="text/javascript" src="inc/assets/js/HostTableManager.js"></script>
<script type="text/javascript" src="inc/assets/js/DBBackupManager.js"></script>
<!-- endbuild -->
</body>
</html>