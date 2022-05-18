<?php
declare(strict_types=1);

namespace App\Service\VHost;


/**
 * Class VHostFileList
 *
 * @package app\hostfile
 */
class VHostFileList
{

    protected $vhostsList = [];

    /**
     * @param VHostFileHandler $vHostFileHandler
     */
    public function add(VHostFileHandler $vHostFileHandler)
    {

        $this->vhostsList[] = $vHostFileHandler;
    }

    /**
     *
     */
    public function reset()
    {

        reset($this->vhostsList);
    }

    /**
     *
     */
    public function clear()
    {

        $this->vhostsList = [];
    }

    /**
     * @return array
     */
    public function getListAsArray()
    {

        return $this->vhostsList;
    }

    /**
     * @return mixed
     */
    public function getNext()
    {

        /** @noinspection OneTimeUseVariablesInspection */
        $vHost = next($this->vhostsList);

        return $vHost;
    }
}