<?php
declare(strict_types=1);

namespace App\Service\VHost;

use App\Service\Config\SystemConfig;
use App\Service\Hostfile\HostList;
use SplFileInfo;

/**
 * Class VHostFileHandler
 *
 * @package app\hostfile
 */
class VHostFileHandler
{

    protected SystemConfig      $systemConfig;
    private VHostTemplateEngine $vHostTemplateEngine;
    /**
     * @var false|string
     */
    private $vhostFilePath;


    public function __construct(SystemConfig $systemConfig, VHostTemplateEngine $vHostTemplateEngine)
    {

        $this->systemConfig        = $systemConfig;
        $this->vHostTemplateEngine = $vHostTemplateEngine;
        $vhostFilePath             = $systemConfig->getVhostDir();
        $this->vhostFilePath       = realpath($vhostFilePath . '/');
    }

    public function writevHostFiles(HostList $hostList)
    {

        $hostFileTemplates = $this->getAllHostFileTemplates();

        foreach ($hostFileTemplates as $hostFileTemplate) {

            $this->writeVhostFile($hostFileTemplate, $hostList);

        }
    }

    /**
     * @return SplFileInfo[]
     */
    public function getAllVHostFiles(): array
    {

        $baseNames      = $this->getAllHostFileTemplates();
        $vHostFileNames = [];
        $vhostDir       = $this->systemConfig->getVhostDir();

        foreach ($baseNames as $vHostBaseName) {

            $extension                     = pathinfo($vHostBaseName, PATHINFO_EXTENSION);
            $vHostBaseNameWithoutExtension = substr($vHostBaseName, 0, -(strlen($extension) + 1));

            $vHostPath = $vhostDir . DIRECTORY_SEPARATOR . $vHostBaseNameWithoutExtension . '.txt';

            if (file_exists($vHostPath)) {
                $vHostFileNames[] = new SplFileInfo(realpath($vHostPath));
            }


        }

        return $vHostFileNames;

    }

    protected function writeVhostFile(string $vhostFileTemplate, HostList $hostList)
    {


        $vHostFileName = $this->createVHostFileName($vhostFileTemplate, 'txt');
        $this->createFileIfNotExist($vHostFileName);
        $content = $this->buildContent($vhostFileTemplate, $hostList);
        $this->writeContentToVhostFile($content, $vHostFileName);

    }

    protected function createVHostFileName(string $templateName, string $newExtension): string
    {

        $splInfo  = new SplFileInfo($templateName);
        $baseName = $splInfo->getBasename('.twig') . '.' . $newExtension;

        return $baseName;
    }

    protected function createFileIfNotExist($vhostFile): SplFileInfo
    {

        $filePath = $this->vhostFilePath . DIRECTORY_SEPARATOR . $vhostFile;

        if (false === file_exists($filePath)) {
            touch($filePath);
        }

        return new SplFileInfo($filePath);

    }

    protected function buildContent(string $template, HostList $hostList): string
    {

        $content = $this->vHostTemplateEngine->buildContent($template, $hostList);

        return $content;
    }

    /**
     * @return string[]
     */
    protected function getAllHostFileTemplates(): array
    {

        $vHostTemplateDir = $this->systemConfig->getAppRoot() .
                            DIRECTORY_SEPARATOR .
                            $this->systemConfig->getVhostTemplatesDirFromAppRoot();

        $vHostTemplateDirReal = realpath($vHostTemplateDir);

        $files = glob($vHostTemplateDirReal . '/*.twig');

        $baseNames = [];

        foreach ($files as $file) {
            $baseNames[] = basename($file);
        }

        return $baseNames;
    }

    protected function writeContentToVhostFile(string $content, string $vHostFileName): void
    {

        $vHostFilePath = $this->systemConfig->getVhostDir() . DIRECTORY_SEPARATOR . $vHostFileName;

        $fh = fopen($vHostFilePath, 'wb+');
        fwrite($fh, $content);
        fclose($fh);

    }

}