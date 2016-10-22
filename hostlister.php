<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 15.06.2014
 * Time: 23:43
 *
 * Created by IntelliJ IDEA
 *
 * Filename: index.php
 */

use computerundsound\culibrary\CuNet;
use hostfile\Host;
use hostfile\Hostfilehandler;
use hostfile\Hostlist;
use hostfile\SortHandler;
use hostfile\VHostFileHandler;
use viewer\MakeView;

include_once __DIR__ . '/inc/_close/includes/_application_viewer.php';

$smarty_standard->assign('sitetitle', 'VHost Lister by cusp.de - Jörg Wrase');

$action    = CuNet::get_post('action');
$action_id = CuNet::get_post('action_id');

if($action === 'phpinfo'){
    phpinfo();
    exit;
}

$sort_handler_coo = new SortHandler('hostlister');

$hostfile_coo = new Hostfilehandler(HOSTFILE_PATH);

$prefix = $hostfile_coo->getPrefix();

$smarty_standard->assign('prefix', $prefix);

$hostfile_content = '';

$update_msg = false;

/* On Update */

/** @noinspection IsEmptyFunctionUsageInspection */
if ($action === 'host_update' && empty($action_id) === false) {
    $data_array = Hostfilehandler::get_post_data_as_array(false, false);
    $dbi_coo->cuUpdate('hosts', $data_array, "host_id='$action_id'");
    $update_msg = true;
}

/** @noinspection IsEmptyFunctionUsageInspection */
if ($action === 'host_kill' && empty($action_id) === false) {
    $dbi_coo->cuDelete('hosts', "host_id = '$action_id'");
    $update_msg = true;
}

if ($action === 'host_add') {
    $data_array                = Hostfilehandler::get_post_data_as_array(false, false);
    $data_array['last_change'] = date('Y-m-d H:i:s');
    $dbi_coo->cuInsert('hosts', $data_array);
    $update_msg = true;
}

/* Prozess Outputs */

/** @var array $server_multi_array */
$server_multi_array = $dbi_coo->selectAsArray('hosts',
                                              '',
                                              $sort_handler_coo->getAktSortItem() . ' '
                                              . $sort_handler_coo->getAktSortDirection() . ', '
                                              . $sort_handler_coo->getAktSortItem() . ' '
                                              . $sort_handler_coo->getAktSortDirection());

$smarty_vhost_coo = new MakeView(CU_SMARTY_DIR);

$vHostFileList = new \hostfile\VHostFileList();
$host_list_coo = new Hostlist();

foreach ($server_multi_array as $server_array) {
    $host_coo = new Host();
    $host_coo->set_host($server_array['host_id'],
                        $server_array['tld'],
                        $server_array['domain'],
                        $server_array['subdomain'],
                        $server_array['ip'],
                        $server_array['comment'],
                        $server_array['last_change'],
                        $server_array['vhost_dir'],
                        $server_array['vhost_htdocs']);

    $host_list_coo->add_host($host_coo);
}

$hostfile_coo->add_host_list($host_list_coo);

if ($action === 'host_prozess_vhostfile') {

    foreach ($vHostFiles as $vHostFileName => $vHostInfos) {
        $vhost_coo = new VHostFileHandler($smarty_vhost_coo, $vHostInfos['templateName'], $vHostFileName);
        $vhost_coo->addHostList($host_list_coo);
        $vhost_coo->build_content();
        $vhost_coo->write_content_to_vhost_file();
    }

    $update_msg = true;
}

$hostfile_coo->build_host_content();
$hostfile_content = $hostfile_coo->getHostFileContent();

$smarty_standard->assign('update_msg', $update_msg);

/* Get Server */

$host_list_coo = new Hostlist();

foreach ($server_multi_array as $server_array) {
    $host_coo = new Host();
    $host_coo->set_host($server_array['host_id'],
                        $server_array['tld'],
                        $server_array['domain'],
                        $server_array['subdomain'],
                        $server_array['ip'],
                        $server_array['comment'],
                        $server_array['last_change'],
                        $server_array['vhost_dir'],
                        $server_array['vhost_htdocs']);

    $host_list_coo->add_host($host_coo);
}

$smarty_standard->assign('hostlist_sorter_options',
                         [
                             'domain'       => 'Domain',
                             'subdomain'    => 'Subdomain',
                             'tld'          => 'Tld',
                             'ip'           => 'IP',
                             'last_change'  => 'Last Change',
                             'vhost_dir'    => 'vhost_dir',
                             'vhost_htdocs' => 'vhost_htdocs',
                         ]);

$smarty_standard->assign('hostlist_sort_handler_item', $sort_handler_coo->getAktSortItem());

$smarty_standard->assign('servers', $host_list_coo);

$smarty_standard->assign('hostfile_content', $hostfile_content);

$smarty_standard->display('c_hosttable.tpl');

if ($action === 'host_prozess_hostfile') {
    $exec_command = $constant_container_coo->getAppRootServer();
    $exec_command = str_replace('/', DIRECTORY_SEPARATOR, $exec_command);
    $exec_command .= EDITOR_COMMAND_OPEN_HOSTFILE;
    exec($exec_command);
}
