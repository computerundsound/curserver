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
require_once __DIR__ . '/../../../_config.php';
require_once __DIR__ . '/../config.system.inc.php';

$constant_container_coo = new CuConstantsContainer('inc/_close/vendor/computerundsound/culibrary');

define('CU_SMARTY_DIR',
       $constant_container_coo->getAppRootServer() .
       'inc' .
       DIRECTORY_SEPARATOR .
       '_close' .
       DIRECTORY_SEPARATOR .
       'views' .
       DIRECTORY_SEPARATOR);

/** @var CuDBi $dbi_coo */
$dbi_coo = CuDBi::getInstance(new CuDBiResult(), DB_SERVER, DB_USER, DB_PW, DB_NAME);

$vHostFiles = unserialize(VHOST_FILES);