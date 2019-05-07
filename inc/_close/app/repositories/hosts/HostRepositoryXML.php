<?php /** @noinspection PhpComposerExtensionStubsInspection */

/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.05.06 at 13:32 MESZ
 */

namespace app\repositories\hosts;

use app\ArrayTrait;
use app\hostfile\Host;
use app\hostfile\HostList;
use app\repositories\RepositoryXML;
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

    /** @var HostList */
    protected $hostList;

    /**
     * @return HostList
     */
    public function getAllHosts()
    {

        $this->loadAllHosts();

        return $this->hostList;


    }

    /**
     * @param Host $host
     *
     * @throws Exception
     */
    public function save(Host $host)
    {

        if ($host->getId()) {

            $this->update($host);

        } else {
            $this->insert($host);
        }

    }

    /**
     * @return int
     */
    public function getNewId()
    {

        $this->loadAllHosts();

        $newId = 0;


        /** @var Host $host */
        foreach ($this->hostList->getHostListArray() as $host) {
            $newId = $host->getId() > $newId ? $host->getId() : $newId;
        }

        $newId++;

        return $newId;

    }

    /**
     * @param int $id
     *
     * @return Host|null
     */
    public function getHostById($id)
    {

        $this->loadAllHosts();

        return $this->hostList->getHostById($id);


    }

    /**
     * @param array $dataArray
     *
     * @throws Exception
     */
    public function saveFromArray(array $dataArray)
    {

        $host = new Host();

        $host->setHost(
            self::getValueFromArray(Host::FieldName_ID, $dataArray, 0),
            self::getValueFromArray(Host::FieldName_tld, $dataArray),
            self::getValueFromArray(Host::FieldName_domain, $dataArray),
            self::getValueFromArray(Host::FieldName_subdomain, $dataArray),
            self::getValueFromArray(Host::FieldName_ip, $dataArray),
            self::getValueFromArray(Host::FieldName_comment, $dataArray),
            new DateTime(),
            self::getValueFromArray(Host::FieldName_vhost_dir, $dataArray),
            self::getValueFromArray(Host::FieldName_vhost_htdocs, $dataArray)
        );

        $this->save($host);


    }

    /**
     * @param int $id
     *
     * @throws Exception
     */
    public function delete($id)
    {

        $this->loadAllHosts();

        $this->hostList->remove($id);

        $this->createFrom($this->hostList);

        $this->updateFile();

    }

    public function reset()
    {

        $this->XMLElement[0] = null;

        $this->updateFile();
    }

    /**
     * @throws Exception
     */
    public function saveCurrentHostList()
    {

        $this->createFrom($this->hostList);
        $this->updateFile();
    }


    /**
     * @param Host $host
     *
     * @throws Exception
     */
    protected function update(Host $host)
    {

        $this->delete($host->getId());
        $this->insert($host);

    }

    protected function loadAllHosts()
    {

        $hostList = new HostList();

        foreach ($this->XMLElement as $element) {

            try {
                $vhost = $this->buildHost($element);
            } catch (Exception $e) {
                continue;
            }

            $hostList->addHost($vhost);

        }

        $this->hostList = $hostList;

    }

    /**
     * @param Host $host
     *
     * @return SimpleXMLElement
     * @throws Exception
     */
    protected function appendHostToXmlElement(Host $host)
    {

        $vhostNode = $this->XMLElement->addChild('vhost', '');
        $vhostNode->addChild('tld', $host->getTld());
        $vhostNode->addChild('domain', $host->getDomain());
        $vhostNode->addChild('subdomain', $host->getSubdomain());
        $vhostNode->addChild('ip', $host->getIp());
        $vhostNode->addChild('comment', $host->getComment());
        $vhostNode->addChild('last_change', $host->getLastChange()->format('Y-m-d H:i:s'));
        $vhostNode->addChild('vhost_dir', $host->getVhostDir());
        $vhostNode->addChild('vhost_htdocs', $host->getVhostHtdocs());

        return $vhostNode;

    }

    /**
     * @param Host $host
     *
     * @throws Exception
     */
    protected function insert(Host $host)
    {

        $vhostNode = $this->appendHostToXmlElement($host);
        $id        = $this->getNewId();
        $vhostNode->addChild('id', $id);

        $this->updateFile();

    }

    protected function updateFile()
    {

        $xmlString = $this->XMLElement->asXML();

        file_put_contents($this->filePathToXML, $xmlString);

    }

    /**
     * @param HostList $hostList
     *
     * @return string
     * @throws Exception
     */
    protected function createFrom(HostList $hostList)
    {

        $this->XMLElement[0] = null;
        $hosts               = $hostList->getHostListArray();
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
    protected function buildHost(SimpleXMLElement $hostXml)
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