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

use computerundsound\culibrary\CuConstantsContainer;
use computerundsound\culibrary\db\mysqli\CuDBi;
use computerundsound\culibrary\db\mysqli\CuDBiResult;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../../../_config.php') === false) {

    die('_config.php file not found. Please make sure that you have the _config.php - file in application root. You can copy the _config.sample.php to _config.php and insert your own values (maybe most values are already good for you');

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
       $constant_container_coo->getAppRootServer() .
       'inc' .
       DIRECTORY_SEPARATOR .
       '_close' .
       DIRECTORY_SEPARATOR .
       'views' .
       DIRECTORY_SEPARATOR);

define('XML_HOST_REPOSITORY_FILE', __DIR__ . '/../../../__writer/vhost_repository.xml');

$vHostFiles = unserialize(VHOST_FILES);