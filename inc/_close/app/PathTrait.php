<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.25 at 02:25 MEZ
 */

namespace app;


/**
 * Trait PathTrait
 *
 * @package app
 */
trait PathTrait
{

    /**
     * @param string $path
     * @param string $directorySeparator
     *
     * @return string
     */
    protected static function buildGoodPath($path, $directorySeparator = DIRECTORY_SEPARATOR)
    {

        $pathNew = preg_replace('#[/\\\]+#', $directorySeparator, $path);

        return $pathNew;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected static function removeDiskLetter($path)
    {

        $pathWithoutDiskLetter = preg_replace('#^[a-zA-Z]?:#', '', $path);

        return $pathWithoutDiskLetter;
    }

}