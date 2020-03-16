<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.06.09 at 04:20 MESZ
 */

use app\hostfile\HostFileHandler;
use app\hostfile\HostListSearch;
use app\hostfile\HostListSorter;
use app\hostfile\SortHandler;
use app\hostfile\VHostFileHandler;
use app\hostfile\VHostFileList;
use app\installer\UpdateController;
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

if ($action === 'xampp_install') {

    $updateController = new UpdateController($constant_container_coo->getAppRootServer());

    ob_start();
    $updateController->update(PATH_TO_VHOSTS, PATH_TO_REPLACEMENT_INI);

    $flashMessage = '<pre>' . ob_get_clean() . '</pre>';

}

$hostFileHandler = new HostFileHandler(HOST_FILE_PATH);

$hostFileHandler->getHostFileContent();

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

try {

    if ($action === 'host_update' && empty($action_id) === false) {
        $dataArray       = HostFileHandler::getPostDataAsArray(false, false);
        $dataArray['id'] = $action_id;
        $hostRepository->saveFromArray($dataArray);
        $updateMessageIsSet = true;
    }

    if ($action === 'host_kill') {
        $hostRepository->delete($action_id);
        $updateMessageIsSet = true;
    }

    if ($action === 'host_add') {
        $dataArray = HostFileHandler::getPostDataAsArray(false, false);
        $hostRepository->saveFromArray($dataArray);
        $updateMessageIsSet = true;
    }
} catch (Exception $exception) {
    $flashMessage = 'Error in Repository: ' . $exception->getMessage();
}

$smartyStandard->assign('port', CU_PORT);

/* Prozess Outputs */

$hostList = $hostRepository->getAllHosts();

$smartyVhost   = new MakeView(CU_SMARTY_DIR);
$vHostFileList = new VHostFileList();

$hostFileHandler->addHostList($hostList);

if ($action === 'host_process_vhostfile') {


    foreach ($vHostFiles->getAllVHostFiles() as $vHostInfos) {

        $vHostFilePath = PATH_TO_VHOSTS . $vHostInfos['fileName'];

        $vhostFileHandler = new VHostFileHandler($smartyVhost,
                                                 $vHostInfos['templateName'],
                                                 $vHostFilePath);

        $vhostFileHandler->createFileIfNotExist();

        $vhostFileHandler->addHostList($hostList);
        try {
            $vhostFileHandler->buildContent(CU_PORT);
        } catch (Exception $e) {
            die('Unable to build host');
        }
        $vhostFileHandler->writeContentToVhostFile();
    }

    $updateMessageIsSet = true;
}

$hostFileHandler->buildHostContent();
$hostfileContent        = $hostFileHandler->getHostFileContent();
$windowsHostFileContent = file_get_contents(HOST_FILE_PATH);
$diffToWindowsHostfile  = false;

if (trim($hostfileContent) !== trim($windowsHostFileContent)) {
    $diffToWindowsHostfile = true;
}

$smartyStandard->assign('diffToWindowsHostfile', $diffToWindowsHostfile);
$smartyStandard->assign('update_msg', $updateMessageIsSet);

$sortHandler   = new SortHandler('hostlister');
$searchHandler = CuRequester::getGetPost('search_handler') ?: '';
$smartyStandard->assign('searchHandlerString', $searchHandler);

if ($searchHandler) {
    $hostListSearcher = new HostListSearch();
    $hostList         = $hostList->search($hostListSearcher, $searchHandler);
}

$hostListSorter = new HostListSorter();

$hostList->sort($hostListSorter, $sortHandler);

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
$smartyStandard->assign('flashMessage', $flashMessage);

try {
    $smartyStandard->display('c_hosttable.tpl');
} catch (Exception $e) {
    die($e->getMessage());
}