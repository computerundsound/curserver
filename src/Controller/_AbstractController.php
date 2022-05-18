<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Page\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class _AbstractController extends AbstractController
{

    protected Page $page;

    /**
     * @param Page $page
     */
    public function __construct(Page $page)
    {

        $javaScriptVariables = [
            'mysqlFileURL' => 'my value',
        ];

        $page->setFromArray(
            [
                'title'               => 'Hosts',
                'h1'                  => 'Host',
                'h2'                  => '',
                'javaScriptVariables' => $javaScriptVariables,
            ]
        );

        $this->page = $page;
    }


}