<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 23:56 MEZ
 */

namespace app\installer\file;


/**
 * Trait PathWorker
 *
 * @package app\installer\file
 */
trait PathWorker
{


    /**
     * @param string $path
     * @param string $directorySeparator
     *
     * @return string
     */
    protected function buildGoodPath(string $path, string $directorySeparator = DIRECTORY_SEPARATOR): string
    {

        $pathNew = preg_replace('#[/\\\]+#', $directorySeparator, $path);

        return $pathNew;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function removeDiskLetter(string $path): string
    {

        $pathWithoutDiskLetter = preg_replace('#^[a-zA-Z]?:#', '', $path);

        return $pathWithoutDiskLetter;
    }

}