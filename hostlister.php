<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.06.09 at 04:20 MESZ
 */

use app\hostfile\HostFileHandler;
use app\hostfile\SortHandler;
use app\hostfile\VHostFileHandler;
use app\hostfile\VHostFileList;
use app\mysql_dumper\CuMysqlDump;
use app\repositories\hosts\HostRepositoryXML;
use app\viewer\MakeView;
use computerundsound\culibrary\CuRequester;

include_once __DIR__ . '/inc/_close/includes/_application_viewer.php';

$smartyStandard->assign('siteTitle', 'VHost Lister by cusp.de - Jörg Wrase');

$action    = CuRequester::getGetPost('action');
$action_id = (int)CuRequester::getGetPost('action_id');

if ($action === 'phpinfo') {
    /** @noinspection ForgottenDebugOutputInspection */
    phpinfo();
    exit;
}

$sortHandler = new SortHandler('hostlister');

$hostFileHandler = new HostFileHandler(HOST_FILE_PATH);

$prefix = $hostFileHandler->getPrefix();

$smartyStandard->assign('prefix', $prefix);

$hostfileContent = '';

$updateMessageIsSet = false;

$mysqlDumper = CuMysqlDump::getInstance($constant_container_coo,
                                        MYSQL_DUMP_FILE_PATH_FROM_APP_ROOT);


$checkMysqlBackupFile = $mysqlDumper->checkMysqlBackupExists();

$smartyStandard->assign('checkMysqlBackupFile', $checkMysqlBackupFile);

$hostRepository = new HostRepositoryXML(XML_HOST_REPOSITORY_FILE);

/* On Update */

/** @noinspection IsEmptyFunctionUsageInspection */
if ($action === 'host_update' && empty($action_id) === false) {
    $dataArray       = HostFileHandler::getPostDataAsArray(false, false);
    $dataArray['id'] = $action_id;
    $hostRepository->saveFromArray($dataArray);
    $updateMessageIsSet = true;
}

/** @noinspection IsEmptyFunctionUsageInspection */
if ($action === 'host_kill') {
    $hostRepository->delete($action_id);
    $updateMessageIsSet = true;
}

if ($action === 'host_add') {
    $dataArray = HostFileHandler::getPostDataAsArray(false, false);
    $hostRepository->saveFromArray($dataArray);
    $updateMessageIsSet = true;
}

$searchHandler = isset($_GET['search_handler']) ? $_GET['search_handler'] : '';
$smartyStandard->assign('searchHandlerString', $searchHandler);

$smartyStandard->assign('port', CU_PORT);

/* Prozess Outputs */

$hostList = $hostRepository->getAllHosts();

$smarty_vhost_coo = new MakeView(CU_SMARTY_DIR);
$vHostFileList    = new VHostFileList();

$hostFileHandler->addHostList($hostList);

if ($action === 'host_prozess_vhostfile') {

    foreach ($vHostFiles as $vHostFileName => $vHostInfos) {
        $vhost_coo = new VHostFileHandler($smarty_vhost_coo, $vHostInfos['templateName'], $vHostFileName);
        $vhost_coo->addHostList($hostList);
        try {
            $vhost_coo->build_content(CU_PORT);
        } catch (Exception $e) {
            die('Unable to build host');
        }
        $vhost_coo->write_content_to_vhost_file();
    }

    $updateMessageIsSet = true;
}

$hostFileHandler->buildHostContent();
$hostfileContent = $hostFileHandler->getHostFileContent();

$smartyStandard->assign('update_msg', $updateMessageIsSet);

/* Get Server */

$smartyStandard->assign('hostlist_sorter_options',
                        [
                            'domain'       => 'Domain',
                            'subdomain'    => 'Subdomain',
                            'tld'          => 'Tld',
                            'ip'           => 'IP',
                            'last_change'  => 'Last Change',
                            'vhost_dir'    => 'vhost_dir',
                            'vhost_htdocs' => 'vhost_htdocs',
                        ]);

$smartyStandard->assign('hostlist_sort_handler_item', $sortHandler->getCurrentSortItem());

$smartyStandard->assign('hosts', $hostList);

$smartyStandard->assign('hostfile_content', $hostfileContent);

try {
    $smartyStandard->display('c_hosttable.tpl');
} catch (Exception $e) {
    die($e->getMessage());
}

if ($action === 'host_prozess_hostfile') {
    $exec_command = $constant_container_coo->getAppRootServer();
    $exec_command = str_replace('/', DIRECTORY_SEPARATOR, $exec_command);
    $exec_command .= EDITOR_COMMAND_OPEN_HOST_FILE;
    exec($exec_command);
}
