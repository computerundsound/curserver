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
    protected $correspondingVHostFileName;

    /**
     * Xampp constructor.
     *
     * @param string $existingXamppDir
     * @param string $correspondingVHostFileName
     */
    public function __construct(string $existingXamppDir, string $correspondingVHostFileName)
    {

        $this->xamppDir                   = realpath($existingXamppDir);
        $this->correspondingVHostFileName = $correspondingVHostFileName;
    }

    /**
     * @param string $dirName
     *
     * @return string
     */
    public static function buildXamppVersion(string $dirName): string
    {

        $versionString = '';

        if (preg_match('/xampp-([^-]*)/', $dirName, $matches)) {

            $versionString = array_key_exists(1, $matches) ? (string)$matches[1] : '';

        }

        return $versionString;
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

        return self::buildXamppVersion($dirName);


    }

    /**
     * @return string
     */
    public function getCorrespondingVHostFileName(): string
    {

        return $this->correspondingVHostFileName;
    }

}