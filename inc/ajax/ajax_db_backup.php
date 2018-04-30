<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 22.10.2016
 * Time: 04:53
 * 
 * Created by IntelliJ IDEA
 *
 */

use app\ajaxresponse\ResponseStandard;
use app\mysql_dumper\CuMysqlDump;
use computerundsound\culibrary\CuRequester;

ini_set('html_errors', 'off');

require_once __DIR__ . '/../_close/includes/_application_top.php';

/** @var \computerundsound\culibrary\CuConstantsContainer $constant_container_coo */

$action = CuRequester::getGetPost('action');

$pathToMysqlBackupFile = $constant_container_coo->getAppRootServer() . MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT;

$pathToMysqlBackupFile = CuMysqlDump::makeGoodPath($pathToMysqlBackupFile, '/', false);

$mysqlDumper = CuMysqlDump::getInstance($constant_container_coo,
                                        MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT);

/** @noinspection DegradedSwitchInspection */
switch ($action) {
    case 'CreateMysqlBackup':

        $ajaxResponse = $mysqlDumper->dumpMysql();
        break;

    case 'DeleteDbBackupFile':
        $ajaxResponse = $mysqlDumper->deleteFile();
        break;

    case 'DownloadBackupFile':
        $mysqlDumper->provideFile();
        exit;
        break;

    case 'RestoreMySqlBackupIntoDataBase':
        $ajaxResponse = $mysqlDumper->restoreMySqlDatabase();
        break;

    default:

        $ajaxResponse = new ResponseStandard(true, 'Unknown Action');

        break;
}

$ajaxResponse->showAsJson();
