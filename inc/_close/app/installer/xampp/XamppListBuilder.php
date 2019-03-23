<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 18:56 MEZ
 */

namespace app\installer\xampp;


use app\installer\file\FileInfo;
use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use app\installer\modifier\ModifyPHPIni;

/**
 * Class XamppListBuilder
 *
 * @package app\installer\xampp
 */
class XamppListBuilder
{

    /**
     * @param string $path
     *
     * @return XamppList
     */
    public function getXamppList(string $path): XamppList
    {

        $dirs = $this->getDirs($path);

        $xamppList = $this->getList($dirs);

        return $xamppList;

    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function getDirs(string $path): array
    {

        $dirs = glob($path . '/*', GLOB_ONLYDIR);

        $dirNames = array_map(function ($dir) {

            $dirFiltered = '';

            $dirName = basename($dir);

            if (strpos($dirName, 'xampp-') === 0) {
                $dirFiltered = realpath($dir);
            }

            return $dirFiltered;

        },
            $dirs);

        return array_filter($dirNames,
            function ($dir) {

                return (bool)$dir;
            });


    }

    /**
     * @param array $dirs
     *
     * @return XamppList
     */
    protected function getList(array $dirs): XamppList
    {

        $xamppList = new XamppList();

        foreach ($dirs as $dir) {

            if ($dir) {
                $xampp = $this->getXampp($dir);
                $xamppList->add($xampp);
            }

        }

        return $xamppList;

    }

    /**
     * @param string $xamppDir
     *
     * @return Xampp
     */
    protected function getXampp($xamppDir): Xampp
    {

        $vHostFilePath = realpath($xamppDir . '/apache/conf/extra/httpd-vhosts.conf');

        $vHostFile = new ModifyConfVHost(
            FileInfo::createInstance($vHostFilePath),
            $xamppDir);

        $mysqlIniPath = realpath($xamppDir . '/mysql/bin/my.ini');

        $mysqlIni = new ModifyMysqlIni(
            FileInfo::createInstance($mysqlIniPath),
            $xamppDir);

        $phpIniPath = realpath($xamppDir . '/php/php.ini');

        $phpIni = new ModifyPHPIni(
            FileInfo::createInstance($phpIniPath),
            $xamppDir);


        return new Xampp($xamppDir,
                         $mysqlIni,
                         $vHostFile,
                         $phpIni);

    }

}