<?php
declare(strict_types=1);

namespace App\Service\Config;

use App\Kernel;

class SystemConfig
{

    protected string $xamppDir;
    protected string $hostFilePath;
    protected string $mysqlFileUrlFromRoot;
    protected string $vhostRepositoryFromAppRoot;
    protected string $vhostDir;
    protected string $standardIp;
    protected string $standardTld;
    protected string $vhostTemplatesDirFromAppRoot;
    protected Kernel $app;

    public function __construct(
        Kernel $app,
        string $xamppDir,
        string $hostFilePath,
        string $mysqlFileUrlFromRoot,
        string $vhostRepositoryFromAppRoot,
        string $vhostDir,
        string $standardIp,
        string $standardTld,
        string $vhostTemplatesDirFromAppRoot)
    {

        $this->xamppDir                     = $xamppDir;
        $this->hostFilePath                 = $hostFilePath;
        $this->mysqlFileUrlFromRoot         = $mysqlFileUrlFromRoot;
        $this->vhostRepositoryFromAppRoot   = $vhostRepositoryFromAppRoot;
        $this->vhostDir                     = $vhostDir;
        $this->standardIp                   = $standardIp;
        $this->standardTld                  = $standardTld;
        $this->vhostTemplatesDirFromAppRoot = $vhostTemplatesDirFromAppRoot;
        $this->app                          = $app;
    }

    /**
     * @return string
     */
    public function getXamppDir(): string
    {

        return $this->xamppDir;
    }

    /**
     * @return string
     */
    public function getHostFilePath(): string
    {

        return $this->hostFilePath;
    }

    /**
     * @return string
     */
    public function getMysqlFileUrlFromRoot(): string
    {

        return $this->mysqlFileUrlFromRoot;
    }

    /**
     * @return string
     */
    public function getVhostRepositoryFromAppRoot(): string
    {

        return $this->vhostRepositoryFromAppRoot;
    }

    /**
     * @return string
     */
    public function getVhostDir(): string
    {

        return $this->vhostDir;
    }

    /**
     * @return string
     */
    public function getStandardIp(): string
    {

        return $this->standardIp;
    }

    /**
     * @return string
     */
    public function getStandardTld(): string
    {

        return $this->standardTld;
    }

    /**
     * @return string
     */
    public function getVhostTemplatesDirFromAppRoot(): string
    {

        return $this->vhostTemplatesDirFromAppRoot;
    }

    public function getAppRoot(): string
    {

        return $this->app->getProjectDir();
    }

}