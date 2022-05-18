<?php
declare(strict_types=1);

namespace App\Service\VHost;

use App\Service\Config\SystemConfig;
use App\Service\Hostfile\Host;
use App\Service\Hostfile\HostList;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Twig\Environment;

class VHostTemplateEngine
{
    protected SystemConfig $systemConfig;
    protected Environment  $twig;


    /**
     * @param SystemConfig $systemConfig
     */
    public function __construct(SystemConfig $systemConfig, Environment $twig)
    {

        $this->systemConfig = $systemConfig;
        $this->twig         = $twig;
    }

    public function buildContent(string $templateName, HostList $hostList): string
    {

        $fullPath = $this->systemConfig->getAppRoot() .
                    DIRECTORY_SEPARATOR .
                    $this->systemConfig->getVhostTemplatesDirFromAppRoot() .
                    DIRECTORY_SEPARATOR .
                    $templateName;

        if (false === file_exists($fullPath)) {
            throw new FileNotFoundException('File ' . $templateName . ' not found');
        }

        $templateContent = file_get_contents($fullPath);
        $content         = '';
        $hostListArray   = $hostList->getHostListArray();

        foreach ($hostListArray as $hostData) {
            $content .= $this->buildHostElementContent($templateContent, $hostData) . "\n";
        }

        return $content;

    }

    protected function buildHostElementContent(string $templateContent, Host $host): string
    {

        $content = $this->twig->createTemplate($templateContent)->render(['host' => $host]);

        return $content;

    }


}