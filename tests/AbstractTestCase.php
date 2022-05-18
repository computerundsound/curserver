<?php
declare(strict_types=1);

namespace App\Tests;

use App\Service\Config\SystemConfig;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AbstractTestCase extends KernelTestCase
{

    protected SystemConfig $systemConfig;

    protected function setUp(): void
    {

        self::bootKernel();
        $container          = static::getContainer();
        $this->systemConfig = $container->get(SystemConfig::class);

        parent::setUp();

    }

}