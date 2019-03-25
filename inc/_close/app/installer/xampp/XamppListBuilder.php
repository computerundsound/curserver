<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 18:56 MEZ
 */

namespace app\installer\xampp;


/**
 * Class XamppListBuilder
 *
 * @package app\installer\xampp
 */
class XamppListBuilder
{

    /**
     * @param string $xamppContainerPath
     *
     * @return XamppList
     */
    public function getXamppList(string $xamppContainerPath): XamppList
    {

        $dirs = $this->getDirs($xamppContainerPath);

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

        return new Xampp($xamppDir);

    }

}