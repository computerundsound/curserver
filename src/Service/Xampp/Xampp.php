<?php
declare(strict_types=1);

namespace App\Service\Xampp;

use App\Service\Config\SystemConfig;
use App\Service\Xampp\ServerConfig\VHostUpdater;
use SplFileInfo;

class Xampp
{


    protected SystemConfig $systemConfig;
    protected VHostUpdater $vHostUpdater;

    public function __construct(SystemConfig $systemConfig, VHostUpdater $vHostUpdater)
    {

        $this->systemConfig = $systemConfig;
        $this->vHostUpdater = $vHostUpdater;
    }

    /**
     * @return SplFileInfo[]
     */
    public function getXamppDirs():array
    {

        $xamppContainerDir = $this->systemConfig->getXamppDir();
        $xamppDirs         = glob($xamppContainerDir . '/xampp*');
        $xampps            = [];

        foreach ($xamppDirs as $xampp) {
            $xampps[] = new SplFileInfo($xampp);
        }


        return $xampps;
    }

}