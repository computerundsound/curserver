<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 23:06 MEZ
 */

namespace _unittests\tests\installer\modifier;

use app\installer\file\FileInfo;
use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use PHPUnit\Framework\TestCase;

/**
 * Class ModifyConfVHostTest
 *
 * @package _unittests\tests\installer\modifier
 */
class ModifyConfVHostTest extends TestCase
{

    protected $modifierVHost;
    /**
     * @var ModifyMysqlIni
     */
    protected $modifierMysqlIni;

    /**
     *
     */
    public function testModify(): void
    {

        $replacer = $this->createMock();

        $this->modifierVHost->modify();
        $this->modifierMysqlIni->modify();

    }

    protected function setUp()
    {

        $filePath = realpath(__DIR__ . '/../../../../../xampp-test/mysql/bin/my.ini');
        $xamppDir = realpath(__DIR__ . '/../../../../../xampp-test/');

        $fileInfo = FileInfo::createInstance($filePath);

        $this->modifierVHost    = new ModifyConfVHost($fileInfo, $xamppDir);
        $this->modifierMysqlIni = new ModifyMysqlIni($fileInfo, $xamppDir);

        parent::setUp();
    }


}
