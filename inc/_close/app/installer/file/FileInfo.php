<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 23:24 MEZ
 */

namespace app\installer\file;


use DomainException;

/**
 * Class FileInfo
 *
 * @package app\installer\file
 */
class FileInfo
{

    protected $dirName;
    protected $baseName;
    protected $extension;
    protected $fileName;

    /**
     * FileInfo constructor.
     *
     * @param $dirName
     * @param $baseName
     * @param $extension
     * @param $fileName
     */
    public function __construct(string $dirName, string $baseName, string $extension, string $fileName)
    {

        $fullPath = $this->createFullPath($dirName, $baseName);

        if (file_exists($fullPath) !== true) {
            throw new DomainException('File ' . $fullPath . ' not found');
        }

        $this->dirName   = $dirName;
        $this->baseName  = $baseName;
        $this->extension = $extension;
        $this->fileName  = $fileName;
    }

    /**
     * @param string $filePath
     *
     * @return FileInfo
     */
    public static function createInstance($filePath)
    {

        $pathInfo = pathinfo($filePath);

        return new self($pathInfo['dirname'],
                        $pathInfo['basename'],
                        $pathInfo['extension'],
                        $pathInfo['filename']);


    }

    /**
     * @return string
     */
    public function getDirName()
    {

        return $this->dirName;
    }

    /**
     * @return string
     */
    public function getBaseName()
    {

        return $this->baseName;
    }

    /**
     * @return string
     */
    public function getExtension()
    {

        return $this->extension;
    }

    /**
     * @return string
     */
    public function getFileName()
    {

        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getFullPath()
    {

        return $this->createFullPath($this->getDirName(), $this->getBaseName());

    }

    /**
     * @param string $dirPath
     * @param string $baseName
     *
     * @return string
     */
    protected function createFullPath($dirPath, $baseName)
    {

        return $dirPath . DIRECTORY_SEPARATOR . $baseName;
    }


}