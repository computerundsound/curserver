<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.25 at 23:46 MEZ
 */

namespace _unittests\tests\installer;

use app\installer\UpdateController;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateControllerTest
 *
 * @package _unittests\tests\installer
 */
class UpdateControllerTest extends TestCase
{
    /**
     *
     */
    public function testUpdate()
    {

        $updateController = new UpdateController();

        $xamppContainerDir = realpath(__DIR__ . '/../../../../');
        $pathToReplacer    = realpath(__DIR__ . '/../../../installer/replacement.ini');

        $updateController->update($xamppContainerDir, $pathToReplacer);

    }


}
