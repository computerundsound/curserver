<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.05.08 at 00:50 MESZ
 */


use app\Debug;
use app\hostfile\Host;
use app\repositories\hosts\HostRepositoryXML;
use computerundsound\culibrary\db\mysqli\CuDBi;
use computerundsound\culibrary\db\mysqli\CuDBiResult;

die('Comment out this line');

require_once __DIR__ . '/../inc/_close/includes/_application_viewer.php';

try {

    /** @var CuDBi $dbi */
    $dbi = CuDBi::getInstance(new CuDBiResult(), DB_SERVER, DB_USER, DB_PW, DB_NAME);

    define('NO_DB_CONNECTION', false);

} catch (Exception $exception) {

    define('NO_DB_CONNECTION', true);

    die('Could not connect do Database. Please make sure that mysql is running and you have insert the credentials in _config.php');
}


$vhosts = $dbi->selectAsArray('hosts');

Debug::printHtml($vhosts);


$hostRepository = new HostRepositoryXML(XML_HOST_REPOSITORY_FILE);

$hostRepository->reset();

$hostList = $hostRepository->getAllHosts();
$hostList->clear();

foreach ($vhosts as $hostArray) {

    $host = new Host();

    $hostId      = $hostArray['host_id'];
    $ip          = $hostArray['ip'];
    $tld         = $hostArray['tld'];
    $domain      = $hostArray['domain'];
    $subdomain   = $hostArray['subdomain'];
    $comment     = $hostArray['comment'];
    $lastChange  = DateTime::createFromFormat('Y-m-d H:i:s', $hostArray['last_change']);
    $vhostDir    = $hostArray['vhost_dir'];
    $vhostHtdocs = $hostArray['vhost_htdocs'];

    $host->setHost($hostId, $tld, $domain, $subdomain, $ip, $comment, $lastChange, $vhostDir, $vhostHtdocs);

    $hostList->addHost($host);

}

$hostRepository->saveCurrentHostList();