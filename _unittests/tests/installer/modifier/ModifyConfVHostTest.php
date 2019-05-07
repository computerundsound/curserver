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
    /** @var ModifyConfVHost */
    protected $modifierVHost;

    /**
     *
     */
    public function testModify()
    {

        $replacer = [
            'vhostFile_if_version_is_greater_or_equal_5.4' => 'cu_vhosts.txt',
            'vhostFile_if_version_is_smaller_than_5.4'     => 'cu_vhosts_5_3.txt',
            'vhostFile_if_version_is_smaller_than_5'       => 'cu_vhosts_4.txt',
        ];

        $this->modifierVHost->modify($replacer);

    }


    protected function setUp()
    {

        $filePath = realpath(__DIR__ . '/../../../../../xampp-test/mysql/bin/my.ini');
        $xamppDir = realpath(__DIR__ . '/../../../../../xampp-test/');

        $fileInfo = FileInfo::createInstance($filePath);

        $this->modifierVHost = new ModifyConfVHost($fileInfo, $xamppDir);

        parent::setUp();
    }


}
