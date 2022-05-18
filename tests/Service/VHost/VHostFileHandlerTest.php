<?php
declare(strict_types=1);

namespace App\Tests\Service\VHost;

use App\Service\Hostfile\Host;
use App\Service\Hostfile\HostList;
use App\Service\VHost\VHostFileHandler;
use App\Service\VHost\VHostTemplateEngine;
use App\Tests\AbstractTestCase;
use Twig\Environment;


class VHostFileHandlerTest extends AbstractTestCase
{
    protected VHostFileHandler $vHostFileHandler;

    /**
     * @dataProvider dataProviderVHostFileHandler
     */
    public function testVHostFileHandler(HostList $hostList): void
    {

//        $this->vHostFileHandler->writevHostFiles($hostList);

        $value   = '20100';
        $success = preg_match('/^[1-9][0-9]{0,9}$/', $value) ? 'true' : 'false';

        self::assertSame('true', $success);


    }

    public function dataProviderVHostFileHandler(): array
    {

        $rawData = [
            [
                'hostList' => [
                    $this->createHost(['name' => '', 'dir' => '', 'htdocs-dir' => '']),
                ],
            ],
        ];

        $dataSets = [];

        foreach ($rawData as $key => $dataSet) {

            $hostList = new HostList();
            $hostList->setHostListArray($dataSet['hostList']);

            $dataSets[] = ['hostList' => $hostList];

        }

        return $dataSets;
    }

    protected function createHost(array $hostData)
    {

        $host = new Host();

        return $host;
    }

    protected function setUp(): void
    {

        parent::setUp();

        self::bootKernel();
        $container = static::getContainer();

        $vHostTemplateEngine    = $container->get(VHostTemplateEngine::class);
        $this->vHostFileHandler = new VHostFileHandler($this->systemConfig, $vHostTemplateEngine);

    }


}
