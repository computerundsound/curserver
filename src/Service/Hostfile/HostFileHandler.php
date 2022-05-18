<?php
declare(strict_types=1);

namespace App\Service\Hostfile;

use App\Service\Config\SystemConfig;

class HostFileHandler
{

    private static string  $hostfileSeparator = '# ************ Next content is from curServer ************';
    protected SystemConfig $systemConfig;
    private array          $hostsArray        = []; // Host
    private string         $prefix;
    private string         $hostFileContent;

    public function __construct(SystemConfig $systemConfig)
    {

        $this->systemConfig = $systemConfig;
        $this->buildHostPrefix();
    }

    protected function buildHostContent(): string
    {

        $hostContent = $this->prefix;
        $hostContent .= self::$hostfileSeparator . PHP_EOL . PHP_EOL;

        /** @var Host $host */
        foreach ($this->hostsArray as $host) {
            $hostContent .= $host->getIp() . "\t" . $host->getFullDomain() . PHP_EOL;
        }

        $this->hostFileContent = $hostContent;

        return $this->hostFileContent;
    }

    public function getHostFileContent(): string
    {

        return $this->hostFileContent ?? $this->buildHostContent();
    }

    public function addHostList(HostList $hostList): HostFileHandler
    {

        $hostListArray = $hostList->getHostListArray();

        foreach ($hostListArray as $host) {
            $this->addHost($host);
        }

        return $this;

    }

    public function addHost(Host $host): HostFileHandler
    {

        $this->hostsArray[] = $host;

        return $this;
    }

    private function buildHostPrefix(): void
    {

        $host_content                = file_get_contents($this->systemConfig->getHostFilePath());
        $host_content_elements_array = explode(self::$hostfileSeparator, $host_content);
        $this->prefix                = $host_content_elements_array[0];
    }
}