<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 03:12
 *
 * Created by IntelliJ IDEA
 *
 * Filename: ajax_get_host_datas.php
 */

use computerundsound\culibrary\CuNet;

require_once __DIR__ . '/../_close/includes/_application_top.php';

$action    = CuNet::get_post('action');
$action_id = CuNet::get_post('action_id');

if ($action !== 'load_host' || empty($action_id)) {
    die('wrong parameter');
}

$dataset_array = $dbi_coo->selectOneDataSet('hosts', 'host_id', $action_id);

$dataset_json = json_encode($dataset_array);

echo $dataset_json;