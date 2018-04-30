<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 16.06.2014
 * Time: 00:02
 *
 * Created by IntelliJ IDEA
 *
 * Filename: Confighandler.php
 */

namespace app\system;

/**
 * Class Confighandler
 *
 * @package app\system
 */
class Confighandler
{

    private $pathToConfigFile;


    /**
     * @param $pathToConfigFile
     */
    public function __construct($pathToConfigFile) {

        $this->pathToConfigFile = $pathToConfigFile;
    }


    /**
     * @return mixed
     */
    public function getPathToConfigFile() {
        return $this->pathToConfigFile;
    }
}