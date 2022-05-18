<?php
declare(strict_types=1);

namespace App\Service\HostRequest;

use App\Service\XmlRepository\Repositories\HostRepositoryXML;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class HostRequest
{

    public function deleteHost(HostRepositoryXML $hostRepositoryXML,
                               string            $hostId,
                               FlashBagInterface $flashBag): void
    {

        try {
            $host = $hostRepositoryXML->getHostById($hostId);
            if (null === $host) {
                $flashBag->add('error',
                               "Es konnte kein Host mit der ID $hostId gefunden werden.");
            } else {
                $hostRepositoryXML->delete($hostId);
                $hostName = $host ? $host->getFullDomain() : 'NICHT GEFUNDEN';
                $flashBag->add('INFO', 'Host ' . $hostName . ' wurde gelöscht');
            }
        } catch (Exception $e) {
            $flashBag->add('ERROR', $e);
        }
    }

    public function addHost(Request           $request,
                            HostRepositoryXML $hostRepositoryXML,
                            FlashBagInterface $flashBag): void
    {

        $dataArray = $request->get('host');
        try {
            $hostRepositoryXML->saveFromArray($dataArray);
            $flashBag->add('INFO', "Es wurde ein neuer Host hinzugefügt");
        } catch (Exception $e) {
            $flashBag->add('ERROR', "Der Host konnte nicht hinzugefügt werden");
        }
    }

}