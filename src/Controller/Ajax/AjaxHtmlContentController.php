<?php
declare(strict_types=1);

namespace App\Controller\Ajax;

use App\Controller\_AbstractController;
use App\Form\EditHostType;
use App\Service\Hostfile\Host;
use App\Service\VHost\VHostFileHandler;
use App\Service\Xampp\ServerConfig\VHostUpdater;
use App\Service\Xampp\Xampp;
use App\Service\XmlRepository\Repositories\HostRepositoryXML;
use DateTime;
use Exception;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxHtmlContentController extends _AbstractController
{

    /**
     * @Route("ajax/html_content/edit_host/{id}", name="ajax.html_content.edit_host")
     *
     * @throws Exception
     */
    public function getEditHost(int $id, HostRepositoryXML $hostRepositoryXML): Response
    {

        $host = $hostRepositoryXML->getHostById($id);

        if (!($host instanceof Host)) {
            throw new RuntimeException('Host not found');
        }

        $form = $this->createForm(EditHostType::class,
                                  [
                                      'id'            => $host->getId(),
                                      'domain'        => $host->getDomain(),
                                      'subdomain'     => $host->getSubdomain(),
                                      'tld'           => $host->getTld(),
                                      'directory'     => $host->getVhostDir(),
                                      'document_root' => $host->getVhostHtdocs(),
                                      'comment'       => $host->getComment(),
                                      'last_change'   => $host->getLastChange(),
                                      'ip'            => $host->getIp(),
                                  ]);

        return $this->render('ajax_contents/host_edit.html.twig', [
            'formHeadline'   => 'Edit Host',
            'hostName'       => $host->getFullDomain(),
            'form_edit_host' => $form->createView(),
        ]);

    }

    /**
     * @Route("ajax/html_content/create_host{id}", name="ajax.html_content.create_host")
     *
     * @throws Exception
     */
    public function editHost(HostRepositoryXML $hostRepositoryXML): Response
    {

        return $this->getHostForm();
    }

    /**
     * @Route("ajax/html_content/create_host", name="ajax.html_content.create_new_host")
     *
     * @throws Exception
     */
    public function createNewHost(HostRepositoryXML $hostRepositoryXML): Response
    {

        return $this->getHostForm();
    }

    /**
     * @Route("/ajax/html_content/delete_host/{id}", name="ajax.html_content.delete_host")
     */
    public function deleteHost(int               $id,
                               HostRepositoryXML $hostRepositoryXML,
                               VHostFileHandler  $vHostFileHandler): Response
    {

        try {
            $success = $hostRepositoryXML->delete($id) ? 'true' : 'false';
        } catch (Exception $e) {
            $success = false;
        }

        $response = new Response($success);

        return $response;
    }

    /**
     * @Route("ajax/write_vhost_files", name="ajax.write_vhost_files")
     */
    public function writeVHostFiles(HostRepositoryXML $hostRepositoryXML, VHostFileHandler $vHostFileHandler): Response
    {

        $hostList = $hostRepositoryXML->getAllHosts();
        $vHostFileHandler->writevHostFiles($hostList);

        return new JsonResponse(['success' => true]);

    }

    /**
     * @Route("/ajax/update_apache_include_vhosts", methods={"POST"}, name="ajax.apache_include_vhosts")
     */
    public function apacheIncludeVhosts(Xampp $xampp, VHostUpdater $vHostUpdater): Response
    {

        $xamppDirs = $xampp->getXamppDirs();

        $pathToApacheVhost = 'apache\conf\extra\httpd-vhosts.conf';

        foreach ($xamppDirs as $xamppFile) {

            $pathToVHostFile = $xamppFile->getRealPath() . DIRECTORY_SEPARATOR . $pathToApacheVhost;

            $vHostUpdater->updateIncludeVHost(new SplFileInfo($pathToVHostFile));

        }


        return new JsonResponse(['success' => false]);

    }

    protected function getHostForm()
    {

        $form = $this->createForm(EditHostType::class,
                                  [
                                      'id'            => '',
                                      'domain'        => '',
                                      'subdomain'     => '',
                                      'tld'           => 'myc',
                                      'directory'     => '',
                                      'document_root' => '',
                                      'comment'       => '',
                                      'last_change'   => new DateTime(),
                                      'ip'            => '127.0.0.1',
                                  ]);

        $response = $this->render('ajax_contents/host_edit.html.twig', [
            'formHeadline'   => 'Create new Host',
            'hostName'       => '',
            'form_edit_host' => $form->createView(),
        ]);

        return $response;
    }

}