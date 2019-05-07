<?php /** @noinspection PhpComposerExtensionStubsInspection */

/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.05.07 at 02:09 MESZ
 */

use app\hostfile\Host;
use app\hostfile\HostList;
use app\repositories\hosts\HostRepositoryXML;
use PHPUnit\Framework\TestCase;

/**
 * Class HostRepositoryTest
 */
class HostRepositoryTest extends TestCase
{

    /** @var SimpleXMLElement */
    protected $xml;
    /**
     * @var HostRepositoryXML
     */
    protected $hostRepository;

    /**
     *
     */
    public function testGetAll()
    {

        $allHosts = $this->hostRepository->getAllHosts();

        $this->assertInstanceOf(HostList::class, $allHosts);


    }

    public function testUpdate()
    {

        $host = new Host();
        $host->setDomain('Domain')
             ->setSubdomain('sub')
             ->setIp('172.212.321')
             ->setComment('Das ist ein Kommentar')
             ->set_last_change();

        $this->hostRepository->save($host);

    }

    protected function setUp()
    {

        $xmlPath = __DIR__ . '/../../../../__writer/vhost_repository.xml';

        $this->hostRepository = new HostRepositoryXML($xmlPath);

        parent::setUp();
    }


}
