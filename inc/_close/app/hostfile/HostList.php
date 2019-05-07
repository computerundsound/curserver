<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 19:34
 *
 * Created by IntelliJ IDEA
 *
 * Filename: Hostlist.php
 */


namespace app\hostfile;

/**
 * Class Hostlist
 *
 * @package app\hostfile
 */
class HostList
{

    /** @var Host[] */
    private $hostListArray = [];


    /**
     * @param Host $host
     */
    public function addHost(Host $host)
    {

        $this->hostListArray[] = $host;
    }


    /**
     * @return array
     */
    public function getHostListArray()
    {

        return $this->hostListArray;
    }

    /**
     * @param $id
     *
     * @return Host|null
     */
    public function getHostById($id)
    {

        $hostToReturn = null;
        foreach ($this->hostListArray as $host) {
            if ($host->getId() === $id) {
                $hostToReturn = $host;
                break;
            }
        }

        return $hostToReturn;

    }

    /**
     * @param int $id
     */
    public function remove($id)
    {

        foreach ($this->hostListArray as $key => $host) {
            if ($host->getId() === $id) {
                unset($this->hostListArray[$key]);
//                break;
            }
        }

    }

    public function clear()
    {

        $this->hostListArray = [];
    }
}