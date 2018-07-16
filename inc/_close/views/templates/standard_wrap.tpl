<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="{$standards.application_root_HTTP}"/>

    <link rel="shortcut icon" href="favicon.ico">

    {if isset($javaScriptVariables)}

        {foreach  key=key item=value from=$javaScriptVariables}
            <meta name="javascriptVariables" content="javaScriptVariables" data-name="{$key}" data-value="{$value}">
        {/foreach}

    {/if}

    <title>{$siteTitle}</title>
    <link rel="stylesheet"
          href="inc/assets/bower_components/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css">

    <link href="inc/assets/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="inc/assets/css/main.css" rel="stylesheet">

</head>

<body>

{*<div id="cuLoader">*}
{*<div>Working :<i class="fas fa-spinner fa-3x fa-spin"></i></div>*}
{*</div>*}

{*<iframe id="cu-iframe" style="display:none;"></iframe>*}

{*<div id="top_impressum_short">*}
{*Jörg Wrase &copy; 2016 - <a href="http://www.cusp.de">cusp.de</a>*}
{*</div>*}

<div class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation">

    <a class="navbar-brand" href="#">{$standards.project_name}</a>
    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div class="navbar-collapse collapse" id="navbarNavDropdown">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="http://localhost/phpmyadmin/" target="_blank" class="nav-link">
                    <i class="fa fa-database" aria-hidden="true"></i> PHPmyAdmin
                </a>
            </li>
            <li class="nav-item">
                <a href="hostlister.php?action=phpinfo" class="nav-link" target="_blank">
                    <i class="fa fa-server" aria-hidden="true"></i> PHPinfo
                </a>
            </li>
            <li class="nav-item">
                <a href="http://www.CUS-production.com" target="_blank" class="nav-link">
                    <i class="fa fa-external-link" aria-hidden="true"></i> www.CUS-production.com
                </a>
            </li>
        </ul>

    </div>

</div>

<div class="container-fluid" style="width: 90%; padding-bottom: 5rem;">
    <div class="row">
        <div class="col-12">

            <h1>curServer</h1>

            <p>
                <button class="btn btn-dark" data-toggle="collapse" data-target="#cuDBInformation">Want to change
                                                                                                   XAMPP-Version? You
                                                                                                   need to backup or
                                                                                                   restore your
                                                                                                   Database: <strong>click
                                                                                                                     here
                                                                                                                     for
                                                                                                                     information.</strong>
                </button>
            </p>

            <div class="collapse" id="cuDBInformation">

                <p>
                    <button class="btn btn-warning hostmask_db_curserver_backup">Make Backup From curserver-DB</button>
                </p>

                <div id="hostmask_db_curserver_backup_info">

                    <h3>How to do this manually:</h3>

                    <p class="text-info">If this will not work, you can do that in your console. Maybe this example will
                                         help you:</p>

                    <p>You can Backup all Databases with your console in your mysql/bin directory:</p>
                    <p><code>mysqldump -u root -p --all-databases > alldb.sql</code></p>

                    <p>Restore your DataBase:</p>
                    <p><code>mysql -u root -p < alldb.sql</code></p>

                    <div class="alert alert-danger">
                        <p>After that - please restart your mysql-Server</p>

                        <p>Be shure that your DatabaseServer you are working on is running.</p>
                        <p>
                            Also make sure that your database is clean.
                        </p>

                        <p class="alert-info">
                            After restoring all database you have to run
                        </p>

                        <pre>FLUSH PRIVILEGES;</pre>

                        <p>in mysql (use <a href="http://localhost/phpmyadmin/" target="_blank">phpmyadmin</a> - select
                           no DB and enter
                           it into the sql-filed).</p>

                    </div>

                    {if $checkMysqlBackupFile}
                        <p>There is a db-backup. What do you want to do?</p>
                        <button class="btn btn-primary hostmask_db_curserver_backup_download">Download the file</button>
                        <button class="btn btn-warning hostmask_db_curserver_backup_delete">Delete the file</button>
                        <button class="btn btn-danger hostmask_db_curserver_backup_restore">Restore into DB</button>
                    {/if}

                </div>
            </div>


            <h1 class="page-header">XAMPP VHost Manager for Windows</h1>

            {block name=content}Content{/block}

        </div>
    </div>

    <!-- Bootstrap-JavaScript
    ================================================== -->
    <!-- Am Ende des Dokuments platziert, damit Seiten schneller laden -->

    <!-- build:js -->
    <script type="text/javascript" src="inc/assets/bower_components/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="inc/assets/bower_components/popper.js/dist/popper.js"></script>
    <script type="text/javascript" src="inc/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="inc/assets/bower_components/bootbox.js/bootbox.js"></script>
    <script type="text/javascript" src="inc/assets/bower_components/mustache.js/mustache.js"></script>
    <script type="text/javascript" src="inc/assets/js/_main.js"></script>
    <script type="text/javascript" src="inc/assets/js/CuLoader.js"></script>
    <script type="text/javascript" src="inc/assets/js/HostTableManager.js"></script>
    <script type="text/javascript" src="inc/assets/js/DBBackupManager.js"></script>
    <!-- endbuild -->
</body>
</html>