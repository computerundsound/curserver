<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\EditHostType;
use App\Service\Hostfile\Host;
use App\Service\Hostfile\HostFileHandler;
use App\Service\XmlRepository\Repositories\HostRepositoryXML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hostlister", name="hostlister_")
 */
class HostlisterController extends _AbstractController
{


    /**
     * @Route("/", name="index")
     */
    public function index(Request           $request,
                          Session           $session,
                          HostFileHandler   $hostFileHandler,
                          HostRepositoryXML $hostRepositoryXML): Response
    {

        $flashBag = $session->getFlashBag();

        $this->page->setFromArray(['showNavbar' => true]);

        $form = $this->createForm(EditHostType::class, ['domain' => 'eine Domain']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $host = Host::createFromArray($data);

            $hostRepositoryXML->save($host);

            $flashBag->add('info', 'Host ' . $host->getFullDomain() . ' has been saved.');

        }

        $hostList        = $hostRepositoryXML->getAllHosts();
        $hostListArray   = $hostList->getHostListArray();
        $hostFileContent = $hostFileHandler->addHostList($hostList)->getHostFileContent();

        return $this->render('pages/hostlister.html.twig',
                             [
                                 'page'            => $this->page,
                                 'hostFileContent' => $hostFileContent,
                                 'hostList'        => $hostListArray,
                                 'formEditHost'    => $form->createView(),
                             ]);
    }


}
