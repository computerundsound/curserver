<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 22.10.2016
 * Time: 04:53
 * 
 * Created by IntelliJ IDEA
 *
 */

require_once __DIR__ . '/../_close/includes/_application_top.php';

/**
 * @param string $action
 * @param string $mysqlDumpFilePath
 * @param bool   $backUpAll
 */
function runMysqlDump($action, $mysqlDumpFilePath, $backUpAll = false) {

    $execStr = 'mysqldump -u ' . DBUSER . ' -p' . DBPW . ' ' . DBNAME . ' > ' . $mysqlDumpFilePath;

    if ($backUpAll) {
        $execStr = 'mysqldump -u ' . DBUSER_ROOT . ' ' . DBPW_ROOT . ' --all-databases --lock-tables=false > ' . $mysqlDumpFilePath;
    }

    $result = exec($execStr, $output, $return);

    $response['action']            = $action;
    $response['mysqlDumpFilePath'] = $mysqlDumpFilePath;

    $response['JSON'] = [
        'result' => $result,
        'output' => $output,
        'return' => $return,
    ];

    array_walk_recursive($response,
        function (&$value) {

            $pattern = '/[äöüÄÖÜß]/';

            if (preg_match($pattern, $value)) {
                $value = utf8_encode($value);
            }


        });

    if ($return === 0 && file_exists($mysqlDumpFilePath)) {
        $response['fileCreated'] = true;
        $response['success']     = true;
    }

    $responseJSON = json_encode($response);

    echo $responseJSON;
}

$response = [
    'fileCreated' => false,
    'success'     => false,
];

$mysqlDumpFilePath = $constant_container_coo->getAppRootServer() . MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT;

$mysqlDumpFilePath = str_replace(['/', '\\', '//', '\\\\'], DIRECTORY_SEPARATOR, $mysqlDumpFilePath);

if (file_exists($mysqlDumpFilePath)) {
    unlink($mysqlDumpFilePath);
}

$action = isset($_POST['action']) ? $_POST['action'] : null;
$secret = isset($_POST['secret']) ? $_POST['secret'] : null;

switch ($action) {
    case 'deleteMySQLDumpFile':
        echo json_encode('File deleted');
        break;
    case 'dbBackupCurServer':
        runMysqlDump($action, $mysqlDumpFilePath);
        break;
    case 'dbBackupAll':
        runMysqlDump($action, $mysqlDumpFilePath, true);
        break;
    default:
        echo json_encode('ERROR');
        break;
}


