<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/info", name="info_")
 */
class InfoController extends _AbstractController
{


    /**
     * @Route("/phpMyAdmin", name="phpMyAdmin")
     */
    public function phpMyAdmin(): Response
    {

        return $this->redirect('http://localhost/phpmyadmin/');
    }

    /**
     * @Route("/phpMyAdmin", name="phpMyAdmin")
     */
    public function phpInfo(): Response
    {

        ob_start();
        phpinfo();
        $content = ob_get_clean();

        return new Response($content);

    }
}
