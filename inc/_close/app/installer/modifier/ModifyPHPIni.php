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
    public function modify(array $replacer): void
    {

        $iniFilePath = $this->fileInfoFromFileToModify->getFullPath();

        $content = $this->getContentFromFile($iniFilePath);

        $contentReplaced = $this->replaceContents($content, $replacer);

        $this->writeContent($iniFilePath, $contentReplaced);

    }

    /**
     * @param Replacer $replacer
     */
    public function addXDebug(Replacer $replacer)
    {

        $contentFromFile = $this->getContentFromFile($this->fileInfoFromFileToModify->getFullPath());

        $xdebugTemplate  = self::getValueFromArray('xdebug_template_standard',
                                                   $replacer->getPhpIniExtend());
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
     * @param array $phpIniExtend
     *
     * @return string
     */
    public function getProfilerDir(array $phpIniExtend): string
    {

        $profilerDirFromXamppContainer = self::getValueFromArray('profilerDirFromXamppContainerDir', $phpIniExtend);

        $profilerDirRaw = $this->xampp->getXamppDir() . DIRECTORY_SEPARATOR . $profilerDirFromXamppContainer;

        $profilerDirGood = self::buildGoodPath($profilerDirRaw);

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        if (!@mkdir($profilerDirGood) && !is_dir($profilerDirGood)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $profilerDirGood));
        }

        $profilerDirReal = realpath($profilerDirGood);

        return $profilerDirReal;
    }

    /**
     * @param string $contentFromFile
     * @param string $xdebugString
     *
     * @return string
     */
    public function buildNewXdebugContent(string $contentFromFile, string $xdebugString): string
    {

        $contentFromFileWithoutXdebug = preg_replace('/\[xdebug\][^\[]*/i', '', $contentFromFile);

        $contentFromFileWithoutXdebug = rtrim($contentFromFileWithoutXdebug);

        $contentNew = $contentFromFileWithoutXdebug . "\n\n" . $xdebugString;

        return $contentNew;
    }

}