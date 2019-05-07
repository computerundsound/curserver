<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.25 at 01:01 MEZ
 */

namespace _unittests\tests\installer\modifier;

use app\installer\file\FileInfo;
use app\installer\modifier\ModifyPHPIni;
use app\installer\Replacer\Replacer;
use app\installer\xampp\Xampp;
use PHPUnit\Framework\TestCase;

/**
 * Class ModifyPHPIniTest
 *
 * @package _unittests\tests\installer\modifier
 */
class ModifyPHPIniTest extends TestCase
{

    /** @var ModifyPHPIni */
    protected $modifyPHPIni;

    /**
     *
     */
    public function testModify()
    {

        $replacerPhpIni = [

            'memory_limit'        => '12M',
            'max_execution_time'  => '80',
            'max_input_time'      => '63',
            'upload_max_filesize' => '5M',

        ];

        $replacer = $this->createMock(Replacer::class);

        $replacer->method('getPhpIniReplacer')->willReturn($replacerPhpIni);

        $this->modifyPHPIni->modify($replacer->getPhpIniReplacer());



    }

    public function testAddXdebug()
    {

        $replacerVHost = [
            'vhostFile_if_version_is_greater_or_equal_5.4' => 'cu_vhosts.txt',
            'vhostFile_if_version_is_smaller_than_5.4'     => 'cu_vhosts_5_3.txt',
            'vhostFile_if_version_is_smaller_than_5'       => 'cu_vhosts_4.txt',
        ];

        $replacerPHPIniExtend = [
            'xdebug_template_standard'         => "[XDebug]\nzend_extension = \"###xamppDir###\\php\\ext\\php_xdebug.dll\"\nxdebug.remote_enable=true\nxdebug.max_nesting_level=450\nxdebug.profiler_enable_trigger=true\nxdebug.profiler_output_dir = \"###profilerDir###\"",
            'profilerDirFromXamppContainerDir' => '..\__profiles',

        ];

        $replacer = $this->createMock(Replacer::class);

        $replacer->method('getPhpIniExtend')->willReturn($replacerPHPIniExtend);
        $replacer->method('getVhostReplacer')->willReturn($replacerVHost);

        $this->modifyPHPIni->addXDebug($replacer);

    }

    protected function setUp()
    {

        $xamppDir = realpath(__DIR__ . '/../../../../../xampp-5.4.27-test');

        $xampp = $this->createMock(Xampp::class);
        $xampp->method('getXamppDir')->willReturn($xamppDir);

        $fileInfo = $this->createMock(FileInfo::class);
        $fileInfo->method('getFullPath')->willReturn(realpath(__DIR__ .
                                                              '/../../../../../xampp-5.4.27-test/php/php.ini'));

        $this->modifyPHPIni = new ModifyPHPIni($fileInfo, $xampp);

        parent::setUp();
    }


}
