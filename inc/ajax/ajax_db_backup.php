<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 22.10.2016
 * Time: 04:53
 * 
 * Created by IntelliJ IDEA
 *
 */

use app\ajaxresponse\ResponseCreateDBBackup;
use app\mysql_dumper\CuMysqlDump;
use computerundsound\culibrary\CuRequester;

require_once __DIR__ . '/../_close/includes/_application_top.php';

/** @var \computerundsound\culibrary\CuConstantsContainer $constant_container_coo */

$action = CuRequester::getGetPost('action');

$pathToMysqlBackupFile = $constant_container_coo->getAppRootServer() . MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT;

$pathToMysqlBackupFile = CuMysqlDump::makeGoodPath($pathToMysqlBackupFile, '/', false);

/** @noinspection DegradedSwitchInspection */
switch ($action) {
    case 'CreateMysqlBackup':

        $mysqlDumper  = CuMysqlDump::getInstance($constant_container_coo,
                                                                   MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT);
        $ajaxResponse = $mysqlDumper->dumpMysql();
        break;

    default:

        $ajaxResponse = new ResponseCreateDBBackup(true, 'Unknown Action', '');

        break;
}

$ajaxResponse->showAsJson();
