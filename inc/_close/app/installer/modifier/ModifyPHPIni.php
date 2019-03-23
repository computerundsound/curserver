<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.20 at 23:10 MEZ
 */

namespace app\installer\modifier;


/**
 * Class ModifyPHPIni
 *
 * @package app\installer\modifier
 */
class ModifyPHPIni extends ModifyFileAbstract implements ModifyInterface
{

    protected static $pathIniFileFromXamppRoot = '/php/php.ini';


    /**
     * @inheritDoc
     */
    public function modify(array $replacer): void
    {

        $iniFilePath = $this->fileInfoFromFileToModify->getFullPath();

        $content = $this->getContentFromFile($iniFilePath);

        $contentReplaced = $this->replaceContents($content, $replacer);

        $this->writeContent($iniFilePath, $contentReplaced);


    }


}