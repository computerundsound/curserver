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
use PHPUnit\Framework\TestCase;

/**
 * Class ModifyConfVHostTest
 *
 * @package _unittests\tests\installer\modifier
 */
class ModifyConfVHostTest extends TestCase
{

    protected $modifier;

    /**
     *
     */
    public function testModify(): void
    {

        $this->modifier->modify();

    }

    protected function setUp()
    {

        $filePath = realpath(__DIR__ . '/../../../../../xampp-test/apache/conf/extra/httpd-vhosts.conf');
        $xamppDir = realpath(__DIR__ . '/../../../../../xampp-test/');

        $fileInfo = FileInfo::createInstance($filePath);

        $this->modifier = new ModifyConfVHost($fileInfo, $xamppDir);

        parent::setUp();
    }


}
