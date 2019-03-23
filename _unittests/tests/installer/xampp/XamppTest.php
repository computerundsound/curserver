<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.23 at 00:25 MEZ
 */

namespace _unittests\tests\installer\xampp;

use app\installer\file\FileInfo;
use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use app\installer\modifier\ModifyPHPIni;
use app\installer\Replacer\ReplaceBuilder;
use app\installer\xampp\Xampp;
use PHPUnit\Framework\TestCase;

/**
 * Class XamppTest
 *
 * @package _unittests\tests\installer\xampp
 */
class XamppTest extends TestCase
{

    protected $xampp;

    public function testUpdate()
    {

        $replaceBuilder = new ReplaceBuilder();

        $replacer = $replaceBuilder->getReplacer(
            __DIR__ . '/../../../../installer/replacement.ini');

        $this->xampp->update($replacer);

    }

    protected function setUp()
    {

        $xamppDir = realpath(__DIR__ . '/../../../../../xampp-test');

        $vHostFilePath = realpath($xamppDir . '/apache/conf/extra/httpd-vhosts.conf');

        $vHostFile = new ModifyConfVHost(
            FileInfo::createInstance($vHostFilePath),
            $xamppDir);

        $mysqlIniPath = realpath($xamppDir . '/mysql/bin/my.ini');

        $mysqlIni = new ModifyMysqlIni(
            FileInfo::createInstance($mysqlIniPath),
            $xamppDir);

        $phpIniPath = realpath($xamppDir . '/php/php.ini');

        $phpIni = new ModifyPHPIni(
            FileInfo::createInstance($phpIniPath),
            $xamppDir);


        $this->xampp = new Xampp($xamppDir,
                                 $mysqlIni,
                                 $vHostFile,
                                 $phpIni);

        parent::setUp();
    }


}
