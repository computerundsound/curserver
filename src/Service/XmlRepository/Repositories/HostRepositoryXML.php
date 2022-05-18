<?php
declare(strict_types=1);

namespace App\Service\XmlRepository\Repositories;

use App\Service\ArrayTools\ArrayTrait;
use App\Service\Hostfile\Host;
use App\Service\Hostfile\HostList;
use App\Service\XmlRepository\RepositoryXML;
use DateTime;
use Exception;
use SimpleXMLElement;

/**
 * Class HostRepository
 *
 * @package app\repositories\hosts
 */
class HostRepositoryXML extends RepositoryXML
{

    use ArrayTrait;

    protected HostList $hostList;

    public function getAllHosts(): HostList
    {

        $this->loadAllHosts();

        return $this->hostList;

    }


    /**
     * Returns the ID
     *
     * @throws Exception
     */
    public function save(Host $host): int
    {

        $host->setLastChange(new DateTime());

        if ($host->getId()) {

            $this->update($host);
            $id = $host->getId();

        } else {
            $id = $this->insert($host);
        }

        return $id;

    }

    /**
     * @return int
     */
    public function getNewId(): int
    {

        $this->loadAllHosts();

        $newId = 0;

        foreach ($this->hostList->getHostListArray() as $host) {
            $newId = max($host->getId(), $newId);
        }

        $newId++;

        return $newId;

    }

    /**
     * @param int $id
     *
     * @return Host|null
     */
    public function getHostById($id): ?Host
    {

        $this->loadAllHosts();

        return $this->hostList->getHostById($id);


    }

    /**
     * Returns the new ID
     *
     * @throws Exception
     */
    public function saveFromArray(array $dataArray): int
    {

        $host = new Host();

        $host->setHost(
            self::getValueFromArray(Host::FIELD_NAME_ID, $dataArray, 0),
            self::getValueFromArray(Host::FIELD_NAME_TLD, $dataArray),
            self::getValueFromArray(Host::FIELD_NAME_DOMAIN, $dataArray),
            self::getValueFromArray(Host::FIELD_NAME_SUBDOMAIN, $dataArray),
            self::getValueFromArray(Host::FIELD_NAME_IP, $dataArray),
            self::getValueFromArray(Host::FIELD_NAME_COMMENT, $dataArray),
            new DateTime(),
            self::getValueFromArray(Host::FIELD_NAME_VHOST_DIR, $dataArray),
            self::getValueFromArray(Host::FIELD_NAME_VHOST_HTDOCS, $dataArray)
        );

        return $this->save($host);


    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {

        $this->loadAllHosts();

        $this->hostList->remove($id);

        $this->createFrom($this->hostList);

        return $this->updateFile();

    }

    public function reset(): void
    {

        $this->simpleXMLElement[0] = null;

        $this->updateFile();
    }

    /**
     * @throws Exception
     */
    public function saveCurrentHostList(): void
    {

        $this->createFrom($this->hostList);
        $this->updateFile();
    }


    /**
     * @param Host $host
     *
     * @throws Exception
     */
    protected function update(Host $host): void
    {

        $this->delete($host->getId());
        $this->insert($host);

    }

    protected function loadAllHosts(): HostList
    {

        $hostList = new HostList();

        foreach ($this->simpleXMLElement as $element) {

            try {
                $vhost = $this->buildHost($element);
            } catch (Exception $e) {
                continue;
            }

            $hostList->addHost($vhost);

        }

        $this->hostList = $hostList;

        return $this->hostList;

    }

    /**
     * @param Host $host
     *
     * @return SimpleXMLElement
     * @throws Exception
     */
    protected function appendHostToXmlElement(Host $host): SimpleXMLElement
    {

        $vhostNode = $this->simpleXMLElement->addChild('vhost', '');
        if ($vhostNode instanceof SimpleXMLElement) {
            $vhostNode->addChild('id', (string)$host->getId());
            $vhostNode->addChild('tld', $host->getTld());
            $vhostNode->addChild('domain', $host->getDomain());
            $vhostNode->addChild('subdomain', $host->getSubdomain());
            $vhostNode->addChild('ip', $host->getIp());
            $vhostNode->addChild('comment', $host->getComment());
            $vhostNode->addChild('last_change', $host->getLastChange()->format('Y-m-d H:i:s'));
            $vhostNode->addChild('vhost_dir', $host->getVhostDir());
            $vhostNode->addChild('vhost_htdocs', $host->getVhostHtdocs());
        }

        return $vhostNode;

    }

    /**
     * @throws Exception
     */
    protected function insert(Host $host): int
    {

        $id = $this->getNewId();
        $host->setId($id);
        $vhostNode = $this->appendHostToXmlElement($host);

        $this->updateFile();

        return $id;

    }

    protected function updateFile(): bool
    {

        $xmlString = $this->simpleXMLElement->asXML();

        $ret = file_put_contents($this->filePathToXML, $xmlString);

        return false !== $ret;

    }

    /**
     * @param HostList $hostList
     *
     * @throws Exception
     */
    protected function createFrom(HostList $hostList): void
    {

        $this->simpleXMLElement[0] = null;
        $hosts                     = $hostList->getHostListArray();
        /** @var Host $host */
        foreach ($hosts as $host) {

            $this->appendHostToXmlElement($host);

        }
    }


    /**
     * @param SimpleXMLElement $hostXml
     *
     * @return Host
     * @throws Exception
     */
    protected function buildHost(SimpleXMLElement $hostXml): Host
    {

        $host = new Host();

        $lastChange = DateTime::createFromFormat('Y-m-d H:i:s', (string)$hostXml->last_change);

        if (!$lastChange) {
            $lastChange = new DateTime();
        }

        $host->setHost((int)$hostXml->id,
                       (string)$hostXml->tld,
                       (string)$hostXml->domain,
                       (string)$hostXml->subdomain,
                       (string)$hostXml->ip,
                       (string)$hostXml->comment,
                       $lastChange,
                       (string)$hostXml->vhost_dir,
                       (string)$hostXml->vhost_htdocs);

        return $host;

    }

}