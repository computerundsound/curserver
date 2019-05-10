<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 17:19 MEZ
 */

namespace app\installer;


use app\installer\file\FileInfo;
use app\installer\InfoPrinter\InfoPrinter;
use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use app\installer\modifier\ModifyPHPIni;
use app\installer\Replacer\ReplaceBuilder;
use app\installer\Replacer\Replacer;
use app\installer\xampp\Xampp;
use app\installer\xampp\XamppListBuilder;
use app\installer\xampp\XamppUpdater;
use app\vhost\VHostFiles;
use Throwable;

/**
 * Class UpdateControler
 *
 * @package app\installer
 */
class UpdateController
{
    /**
     * @var string
     */
    protected $appRootDir;

    /**
     * UpdateController constructor.
     *
     * @param string $appRootDir
     */
    public function __construct(string $appRootDir)
    {

        $this->appRootDir = $appRootDir;
    }

    /**
     * @param string $xamppContainerPath
     * @param string $pathToReplacerIni
     */
    public function update($xamppContainerPath, $pathToReplacerIni)
    {

        $replaceBuilder = new ReplaceBuilder();
        $replacer       = $replaceBuilder->getReplacer($pathToReplacerIni);

        $xamppController = new XamppListBuilder();

        $vHostFile = new VHostFiles(VHOST_FILES);

        $xamppList = $xamppController->getXamppList($xamppContainerPath, $replacer, $vHostFile);

        $xamppListArray = $xamppList->getXampps();

        InfoPrinter::info('Xampp list: ', $xamppListArray);


        foreach ($xamppListArray as $xampp) {

            try {
                $this->updateXampp($xampp, $replacer);
            } catch (Throwable $e) {

                InfoPrinter::warning('Error updating xamppDir ' . $xampp->getXamppDir());

            }
        }

    }

    /**
     * @param Xampp    $xampp
     * @param Replacer $replacer
     */
    protected function updateXampp(Xampp $xampp, Replacer $replacer)
    {

        $xamppDir = $xampp->getXamppDir();

        InfoPrinter::info('Current XamppDir: ' . $xamppDir);

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
                                         $modifyPhpIni,
                                         $this->appRootDir);

        $xamppUpdater->update($replacer);

    }

}

