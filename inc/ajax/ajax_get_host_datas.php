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

use app\repositories\hosts\HostRepositoryXML;
use computerundsound\culibrary\CuRequester;

ini_set('html_errors', false);

require_once __DIR__ . '/../_close/includes/_application_top.php';

$action    = CuRequester::getGetPost('action');
$action_id = (int)CuRequester::getGetPost('action_id');

if ($action !== 'load_host' || !is_numeric($action_id)) {
    die('wrong parameter');
}

$hostRepository = new HostRepositoryXML(XML_HOST_REPOSITORY_FILE);
$host           = $hostRepository->getHostById($action_id);

$out = json_encode($host);

echo $out;