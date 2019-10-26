<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.20 at 00:41 MEZ
 */

namespace app\installer\modifier;


/**
 * Class ModifyMysqlIni
 *
 * @package app\installer\modifier
 */
class ModifyMysqlIni extends ModifyFileAbstract implements ModifyInterface
{

    protected static $pathIniFileFromXamppRoot         = '/mysql/bin/my.ini';
    protected static $pathIniFileBackupFromXamppRoot   = '/mysql/bin/my-backup.ini';
    protected static $pathIniTemplateFileFromXamppRoot = '/mysql/my-huge.ini';

    protected $pathIniFile;
    protected $pathIniBackupFile;
    protected $pathIniTemplateFile;

    /**
     * @inheritDoc
     *
     * @return ModifyMysqlIni
     */
    public function modify(array $replacer)
    {

        self::$pathIniTemplateFileFromXamppRoot = isset($replacer['copyContentFrom']) ?
            $replacer['copyContentFrom'] :
            self::$pathIniTemplateFileFromXamppRoot;

        $this->buildPaths();
        if (realpath($this->pathIniFile)) {

            $this->backup();

            if (realpath($this->pathIniTemplateFile)) {
                $this->copyTemplate($replacer);
            }


        }

    }

    protected function buildPaths()
    {

        $xamppDir = $this->xampp->getXamppDir();

        $this->pathIniFile         = self::buildGoodPath($xamppDir . self::$pathIniFileFromXamppRoot);
        $this->pathIniBackupFile   = self::buildGoodPath($xamppDir . self::$pathIniFileBackupFromXamppRoot);
        $this->pathIniTemplateFile = self::buildGoodPath($xamppDir . self::$pathIniTemplateFileFromXamppRoot);

    }

    protected function backup()
    {

        $content = $this->getContentFromFile($this->pathIniFile);
        $this->writeContent($this->pathIniBackupFile, $content);

    }

    /**
     * @param array $replacer
     *
     * @return void
     */
    protected function copyTemplate(array $replacer)
    {

        $content = $this->getContentFromFile($this->pathIniTemplateFile);

        $contentNew = $this->replaceContents($content, $replacer);

        $this->writeContent($this->pathIniFile, $contentNew);


    }


}