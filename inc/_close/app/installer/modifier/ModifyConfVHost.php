<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 23:02 MEZ
 */

namespace app\installer\modifier;

use app\ArrayTrait;

/**
 * Class ModifyConfVHost
 *
 * @package app\installer\modifier
 */
class ModifyConfVHost extends ModifyFileAbstract implements ModifyInterface
{

    use ArrayTrait;

    /**
     * @inheritDoc
     *
     * @return ModifyConfVHost
     */
    public function modify(array $replacer): ModifyInterface
    {

        $content      = $this->getContentFromFile($this->fileInfoFromFileToModify->getFullPath());
        $insertString = $this->buildInsertString();

        if (strpos($content, $insertString) === false) {

            $contentNew = $content . "\n" . $insertString;

            $this->writeContent($this->fileInfoFromFileToModify->getFullPath(), $contentNew);

        }

    }

    /**
     * @return string
     */
    protected function buildInsertString(): string
    {

        $path = $this->xampp->getXamppDir() . '/' . $this->xampp->;

        $pathWithoutDriveLetter = self::removeDiskLetter($path);

        $pathWithoutDriveLetterClean = self::buildGoodPath($pathWithoutDriveLetter, '/');

        $insertString = 'include "' . $pathWithoutDriveLetterClean . '"';

        return $insertString;
    }

}