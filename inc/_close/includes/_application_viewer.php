<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 27.06.2014
 * Time: 01:45
 *
 * Created by IntelliJ IDEA
 *
 * Filename: _application_viewer.php
 */

use app\viewer\MakeView;

require_once __DIR__ . '/_application_top.php';

$smartyStandard = new MakeView(CU_SMARTY_DIR);

$standards_view_elements = [
    'application_root_HTTP' => $constant_container_coo->getAppRootHTTP(),
    'project_name'          => 'curServer',
    'php_self'              => $constant_container_coo->getFilePath_HTTP(),
];

$content
    = <<<HTML
	<p>{$standards_view_elements['application_root_HTTP']}</p>
HTML;

$flashMessage = '';

$smartyStandard->assign('siteTitle', '');
$smartyStandard->assign('standards', $standards_view_elements);
$smartyStandard->assign('content', $content);
$smartyStandard->assign('flashMessage', $flashMessage);

$smartyStandard->assign('javaScriptVariables',
                        [
                            'mysqlFileURL' => MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT,
                            'secret'       => AJAX_SECRET,
                            'standardTLD'  => STANDARD_TLD,
                        ]);