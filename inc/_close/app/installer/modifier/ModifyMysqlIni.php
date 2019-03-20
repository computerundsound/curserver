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
     */
    public function modify(array $replacer): void
    {

        $this->buildPaths();
        $this->backup();
        $this->copyTemplate($replacer);
        exit;


    }

    protected function buildPaths()
    {

        $this->pathIniFile         = $this->buildGoodPath($this->xamppDir . self::$pathIniFileFromXamppRoot);
        $this->pathIniBackupFile   = $this->buildGoodPath($this->xamppDir . self::$pathIniFileBackupFromXamppRoot);
        $this->pathIniTemplateFile = $this->buildGoodPath($this->xamppDir . self::$pathIniTemplateFileFromXamppRoot);

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
    protected function copyTemplate(array $replacer): void
    {

        $content = $this->getContentFromFile($this->pathIniTemplateFile);

        $contentNew = $this->replaceContents($content, $replacer);

        $this->writeContent($this->pathIniFile, $contentNew);


    }

    /**
     * @param string $content
     * @param array  $replacer
     *
     * @return string
     */
    protected function replaceContents(string $content, array $replacer): string
    {

        foreach ($replacer as $search => $newValue) {
            $content = $this->replaceLine($search, $newValue, $content);
        }

        return $content;
    }

    /**
     * @param string $search
     * @param string $newValue
     * @param string $content
     *
     * @return string
     */
    protected function replaceLine(string $search, string $newValue, string $content): string
    {

        $replace = "$search = $newValue";

        $content = preg_replace("/^[\\s]*$search.*/m", $replace, $content);

        return $content;

    }


}