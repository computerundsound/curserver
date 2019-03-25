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

    public function _testUpdate(): void
    {

        $replaceBuilder = new ReplaceBuilder();

        $replacer = $replaceBuilder->getReplacer(
            __DIR__ . '/../../../../installer/replacement.ini');

//        $this->xampp->update($replacer);

    }

    public function testGetVersion(): void
    {

        $xamppDir = __DIR__ . '/xampp-232.23-paff';

        $modifyMySqlIni = $this->createMock(ModifyMysqlIni::class);
        $modifyConfHost = $this->createMock(ModifyConfVHost::class);
        $modifyPHPIni   = $this->createMock(ModifyPHPIni::class);

        $xampp = new Xampp($xamppDir,
                           $modifyMySqlIni,
                           $modifyConfHost,
                           $modifyPHPIni);

        $version = $xampp->getXamppVersion();

        $this->assertSame('232.23', $version);


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
