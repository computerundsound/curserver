<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 16.06.2014
 * Time: 01:37
 *
 * Created by IntelliJ IDEA
 *
 * Filename: _application_top.php
 */

use app\vhost\VHostFiles;
use computerundsound\culibrary\CuConstantsContainer;

if (!defined('CU_SEND_SESSION') || CU_SEND_SESSION === true) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../../../_config.php') === false) {

    copy(__DIR__ . '/../../../_config.sample.php', __DIR__ . '/../../../_config.php');


}

require_once __DIR__ . '/../../../_config.php';
require_once __DIR__ . '/../config.system.inc.php';

/**
 * @param mixed $value
 * @param bool  $endScript
 */
function cuPrint($value, $endScript = false)
{

    $value = (array)$value;

    $output = '<pre>' . print_r($value, true) . '</pre>';

    echo $output;

    if ($endScript) {
        exit;
    }

}

$constant_container_coo = new CuConstantsContainer('/');

define('CU_SMARTY_DIR',
       dirname(dirname(dirname(__DIR__))) . '/' .
       'inc' .
       DIRECTORY_SEPARATOR .
       '_close' .
       DIRECTORY_SEPARATOR .
       'views' .
       DIRECTORY_SEPARATOR);

define('XML_HOST_REPOSITORY_FILE', __DIR__ . '/../../../__writer/vhost_repository.xml');
define('PATH_TO_REPLACEMENT_INI', __DIR__ . '/../../../installer/replacement.ini');

if (file_exists(XML_HOST_REPOSITORY_FILE) === false) {
    $fh = fopen(XML_HOST_REPOSITORY_FILE, 'wb+');
    fwrite($fh, '<?xml version="1.0" encoding="UTF-8"?><vhosts></vhosts>');
    fclose($fh);
}

$vHostFiles = new VHostFiles();

foreach ($vHostFiles->getAllVHostFiles() as $vHostFile) {

    $fileName = $vHostFile['fileName'];

    $vHostPath = PATH_TO_VHOSTS . $fileName;

    if (file_exists($vHostPath) === false) {
        touch($vHostPath);
    }

}