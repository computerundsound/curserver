<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.20 at 23:10 MEZ
 */

namespace app\installer\modifier;


use app\ArrayTrait;
use app\installer\Replacer\Replacer;
use RuntimeException;

/**
 * Class ModifyPHPIni
 *
 * @package app\installer\modifier
 */
class ModifyPHPIni extends ModifyFileAbstract implements ModifyInterface
{

    use ArrayTrait;

    protected static $pathIniFileFromXamppRoot = '/php/php.ini';


    /**
     * @inheritDoc
     *
     * @return ModifyPHPIni
     */
    public function modify(array $replacer)
    {

        $iniFilePath = $this->fileInfoFromFileToModify->getFullPath();

        $content = $this->getContentFromFile($iniFilePath);

        $contentReplaced = $this->replaceContents($content, $replacer);

        $this->writeContent($iniFilePath, $contentReplaced);

    }

    /**
     * @param Replacer $replacer
     * @param string   $appRootDir
     */
    public function addXDebug(Replacer $replacer, $appRootDir)
    {

        $contentFromFile = $this->getContentFromFile($this->fileInfoFromFileToModify->getFullPath());

        $xdebugTemplateFileName = self::getValueFromArray('xdebug_template_standard_template_file',
                                                          $replacer->getPhpIniExtend());

        $xdebugTemplate  = $this->getXdebugIniTemplate($xdebugTemplateFileName, $appRootDir);
        $phpIniExtend    = $replacer->getPhpIniExtend();
        $profilerDirReal = $this->getProfilerDir($phpIniExtend);

        $xdebugString = str_replace(array('###xamppDir###', '###profilerDir###'),
                                    array($this->xampp->getXamppDir(), $profilerDirReal),
                                    $xdebugTemplate);

        $xdebugString = preg_replace('/(?<!\\\)\\\n/u', "\n", $xdebugString);

        $contentNew = $this->buildNewXdebugContent($contentFromFile, $xdebugString);

        $this->writeContent($this->fileInfoFromFileToModify->getFullPath(), $contentNew);

    }

    /**
     * @param string $fileName
     * @param string $appRootDir
     *
     * @return string
     */
    protected function getXdebugIniTemplate($fileName, $appRootDir)
    {

        $content = file_get_contents($appRootDir .
                                     '/installer/php.ini/' .
                                     $fileName);

        return $content;


    }

    /**
     * @param array $phpIniExtend
     *
     * @return string
     */
    public function getProfilerDir(array $phpIniExtend)
    {

        $profilerDirFromXamppContainer = self::getValueFromArray('profilerDirFromXamppContainerDir', $phpIniExtend);

        $profilerDirRaw = $this->xampp->getXamppDir() . DIRECTORY_SEPARATOR . $profilerDirFromXamppContainer;

        $profilerDirGood = self::buildGoodPath($profilerDirRaw);

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        if (!@mkdir($profilerDirGood) && !is_dir($profilerDirGood)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $profilerDirGood));
        }

        return realpath($profilerDirGood);

    }

    /**
     * @param string $contentFromFile
     * @param string $xdebugString
     *
     * @return string
     */
    public function buildNewXdebugContent($contentFromFile, $xdebugString)
    {

        $contentFromFileWithoutXdebug = preg_replace('/\[xdebug\][^\[]*/i', '', $contentFromFile);
        $contentFromFileWithoutXdebug = rtrim($contentFromFileWithoutXdebug);

        return $contentFromFileWithoutXdebug . "\n\n" . $xdebugString;

    }

}