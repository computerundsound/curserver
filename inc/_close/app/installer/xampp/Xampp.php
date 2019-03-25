<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 22:59 MEZ
 */

namespace app\installer\xampp;


/**
 * Class Xampp
 *
 * @package app\installer
 */
class Xampp
{

    /**
     * @var string
     */
    protected $xamppDir;
    /**
     * @var string
     */
    protected $correspondingVHostFilePath;

    /**
     * Xampp constructor.
     *
     * @param string $existingXamppDir
     * @param string $correspondingVHostFilePath
     */
    public function __construct(string $existingXamppDir, string $correspondingVHostFilePath)
    {

        $this->xamppDir                   = realpath($existingXamppDir);
        $this->correspondingVHostFilePath = realpath($correspondingVHostFilePath);
    }

    /**
     * @return string
     */
    public function getXamppDir(): string
    {

        return $this->xamppDir;
    }

    /**
     * @return string
     */
    public function getXamppDirName(): string
    {

        return basename($this->xamppDir);

    }

    /**
     * @return string
     */
    public function getXamppVersion(): string
    {

        $dirName = $this->getXamppDirName();

        $versionString = '';

        if (preg_match('/xampp-([^-]*)/', $dirName, $matches)) {

            $versionString = array_key_exists(1, $matches) ? (string)$matches[1] : '';

        }

        return $versionString;
    }

    /**
     * @return string
     */
    public function getCorrespondingVHostFilePath(): string
    {

        return $this->correspondingVHostFilePath;
    }

}