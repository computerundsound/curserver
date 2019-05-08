<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.05.08 at 09:59 MESZ
 */

namespace app\hostfile;


/**
 * Class HostListSearch
 *
 * @package app\hostfile
 */
class HostListSearch
{

    /**
     * @param HostList $hostList
     * @param string   $searchString
     *
     * @return HostList
     */
    public function search(HostList $hostList, $searchString)
    {

        $hostListSearch = new HostList();
        $hosts          = $hostList->getHostListArray();

        foreach ($hosts as $host) {
            if ($this->searchInHost($host, $searchString)) {
                $hostListSearch->addHost($host);
            }
        }

        return $hostListSearch;
    }

    /**
     * @param Host   $host
     * @param string $searchString
     *
     * @return bool
     */
    protected function searchInHost(Host $host, $searchString)
    {

        $success = false;

        if (strpos($host->getFullDomain(), $searchString) > 0) {
            $success = true;
        }

        if (strpos($host->getVhostHtdocs(), $searchString) > 0) {
            $success = true;
        }

        if (strpos($host->getVhostDir(), $searchString) > 0) {
            $success = true;
        }

        if (strpos($host->getIp(), $searchString) > 0) {
            $success = true;
        }

        return $success;
    }
}