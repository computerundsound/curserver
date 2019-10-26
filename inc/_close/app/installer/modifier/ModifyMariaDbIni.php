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
class ModifyMariaDbIni extends ModifyFileAbstract implements ModifyInterface
{

    protected static $pathIniFileFromXamppRoot = '/mysql/bin/my.ini';


    protected $pathIniFile;


    /**
     * @inheritDoc
     *
     * @return ModifyMysqlIni
     */
    public function modify(array $replacer)
    {

        $iniFilePath = $this->fileInfoFromFileToModify->getFullPath();

        $content = $this->getContentFromFile($iniFilePath);

        $contentReplaced = $this->replaceContents($content, $replacer);

        $this->writeContent($iniFilePath, $contentReplaced);


    }


}