<?php

declare(strict_types=1);

namespace App\Service\Hostfile;

/**
 * Class Hostlist
 *
 * @package app\hostfile
 */
class HostList
{

    /** @var Host[] */
    private array $hostListArray = [];

    public function addHost(Host $host): HostList
    {

        $this->hostListArray[] = $host;

        return $this;
    }


    /**
     * @return Host[]
     */
    public function getHostListArray(): array
    {
        return $this->hostListArray;
    }

    public function getHostById(int $id): ?Host
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

    public function remove(int $id): HostList
    {

        foreach ($this->hostListArray as $key => $host) {
            if ($host->getId() === $id) {
                unset($this->hostListArray[$key]);
//                break;
            }
        }

        return $this;

    }

    public function clear(): HostList
    {

        $this->hostListArray = [];

        return $this;
    }

    /**
     * @param Host[] $hosts
     *
     * @return $this
     */
    public function setHostListArray(array $hosts): HostList
    {
        foreach ($hosts as $host) {
            $this->addHost($host);
        }

        return $this;
    }
}