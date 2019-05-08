<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.05.08 at 11:12 MESZ
 */

namespace app\hostfile;


/**
 * Class HostListSorter
 *
 * @package app\hostfile
 */
class HostListSorter
{


    /**
     * @param HostList    $hostList
     * @param SortHandler $sortHandler
     */
    public function sort(HostList $hostList, SortHandler $sortHandler)
    {

        switch ($sortHandler->getCurrentSortItem()) {
            case Host::FieldName_ip:
                $this->sortIp($hostList);
                break;
            case Host::FieldName_subdomain:
                $this->sortSubdomain($hostList);
                break;
            case Host::FieldName_domain:
                $this->sortDomain($hostList);
                break;
            case Host::FieldName_tld:
                $this->sortTld($hostList);
                break;
            case Host::FieldName_comment:
                $this->sortComment($hostList);
                break;
            case Host::FieldName_vhost_dir:
                $this->sortVhostDir($hostList);
                break;
            case Host::FieldName_vhost_htdocs:
                $this->sortVhostHtdocs($hostList);
                break;
        }
    }


    /**
     * @param HostList $hostList
     */
    protected function sortIp(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getIp() > $hostB->getIp();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortSubdomain(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getSubdomain() > $hostB->getSubdomain();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortDomain(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getDomain() > $hostB->getDomain();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortTld(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getTld() > $hostB->getTld();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortComment(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getComment() > $hostB->getComment();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortVhostDir(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getVhostDir() > $hostB->getVhostDir();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortVhostHtdocs(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getVhostHtdocs() > $hostB->getVhostHtdocs();
            });

        $hostList->setHostListArray($hostListArray);

    }

    /**
     * @param HostList $hostList
     */
    protected function sortLastChange(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();
        usort($hostListArray,
            function (Host $hostA, Host $hostB) {

                return $hostA->getLastChange() < $hostB->getLastChange();
            });

        $hostList->setHostListArray($hostListArray);

    }


}