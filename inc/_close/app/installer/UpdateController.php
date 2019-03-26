<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 17:19 MEZ
 */

namespace app\installer;


use app\installer\file\FileInfo;
use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use app\installer\modifier\ModifyPHPIni;
use app\installer\Replacer\ReplaceBuilder;
use app\installer\Replacer\Replacer;
use app\installer\xampp\Xampp;
use app\installer\xampp\XamppListBuilder;
use app\installer\xampp\XamppUpdater;

/**
 * Class UpdateControler
 *
 * @package app\installer
 */
class UpdateController
{

    /**
     * @param string $xamppContainerPath
     * @param string $pathToReplacerIni
     */
    public function update(string $xamppContainerPath, $pathToReplacerIni): void
    {

        $replaceBuilder = new ReplaceBuilder();
        $replacer       = $replaceBuilder->getReplacer($pathToReplacerIni);

        $xamppController = new XamppListBuilder();

        $xamppList = $xamppController->getXamppList($xamppContainerPath, $replacer);

        $xamppListArray = $xamppList->getXampps();


        foreach ($xamppListArray as $xampp) {

            $this->updateXampp($xampp, $replacer);

        }

    }

    /**
     * @param Xampp    $xampp
     * @param Replacer $replacer
     */
    protected function updateXampp(Xampp $xampp, Replacer $replacer): void
    {

        $xamppDir = $xampp->getXamppDir();

        $vHostFilePath = realpath($xamppDir . '/apache/conf/extra/httpd-vhosts.conf');

        $modifyConfVHost = new ModifyConfVHost(
            FileInfo::createInstance($vHostFilePath),
            $xampp);

        $mysqlIniPath = realpath($xamppDir . '/mysql/bin/my.ini');

        $modifyMysqlIni = new ModifyMysqlIni(
            FileInfo::createInstance($mysqlIniPath),
            $xampp);

        $phpIniPath = realpath($xamppDir . '/php/php.ini');

        $modifyPhpIni = new ModifyPHPIni(
            FileInfo::createInstance($phpIniPath),
            $xampp);

        $xamppUpdater = new XamppUpdater($xampp,
                                         $modifyMysqlIni,
                                         $modifyConfVHost,
                                         $modifyPhpIni);

        $xamppUpdater->update($replacer);

    }

}
