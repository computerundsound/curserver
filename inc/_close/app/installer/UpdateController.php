<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 17:19 MEZ
 */

namespace app\installer;


use app\installer\xampp\XamppListBuilder;

/**
 * Class UpdateControler
 *
 * @package app\installer
 */
class UpdateController
{

    /**
     * @param string $xamppDir
     * @param string $pathToReplacerIni
     */
    public function update(string $xamppDir, $pathToReplacerIni)
    {

        $xamppController = new XamppListBuilder();

        $xamppList = $xamppController->getXamppList($xamppDir);

        $xamppListArray = $xamppList->getXampps();

        $replaceBuilder = new Replacer\ReplaceBuilder();
        $replacer       = $replaceBuilder->getReplacer($pathToReplacerIni);

        foreach ($xamppListArray as $xampp) {

            $xampp->update($replacer);

        }

    }

}
