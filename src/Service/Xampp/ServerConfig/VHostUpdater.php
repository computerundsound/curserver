<?php
declare(strict_types=1);

namespace App\Service\Xampp\ServerConfig;

use SplFileInfo as SplFileInfoAlias;

class VHostUpdater
{

    /**
     * @param SplFileInfoAlias $vHostFile
     *
     * @return void
     */
    public function updateIncludeVHost(SplFileInfoAlias $vHostFile)
    {

        $content = file_get_contents($vHostFile->getRealPath());

        $pattern = '/^include ".*$/im';

        $contentRaw = preg_replace($pattern, '', $content);

        $contentUpdated = $contentRaw . "\n\n" . 'include "/CUSP/_PROGGEN/_SERVER/_____XAMPPS/vhost.txt"';

        file_put_contents($vHostFile->getRealPath(), $contentUpdated);

    }

}