<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 12.09.2015
 * Time: 03:34
 * 
 * Created by IntelliJ IDEA
 *
 */

namespace app\hostfile;


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
    public function add(VHostFileHandler $vHostFileHandler): void
    {

        $this->vhostsList[] = $vHostFileHandler;
    }

    /**
     *
     */
    public function reset(): void
    {

        reset($this->vhostsList);
    }

    /**
     *
     */
    public function clear(): void
    {

        $this->vhostsList = [];
    }

    /**
     * @return array
     */
    public function getListAsArray(): array
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