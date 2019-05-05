<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 01.07.2014
 * Time: 00:37
 *
 * Created by IntelliJ IDEA
 *
 * Filename: VHostFileHandler.php
 */

namespace app\hostfile;

use app\viewer\MakeView;
use Exception;
use Smarty;
use SmartyException;

/**
 * Class VHostFileHandler
 *
 * @package app\hostfile
 */
class VHostFileHandler
{

    private $hosts_array = [];
    /**
     * @var Smarty
     */
    private $smarty_vhost;
    private $smarty_tpl;

    private $content;
    private $vhost_file_path;


    /**
     * @param Smarty|MakeView $smarty_vhost
     * @param                 $smarty_tpl
     * @param                 $vhost_file_path
     */
    public function __construct(MakeView $smarty_vhost, $smarty_tpl, $vhost_file_path)
    {

        $this->smarty_vhost    = $smarty_vhost;
        $this->smarty_tpl      = $smarty_tpl;
        $this->vhost_file_path = $vhost_file_path;
    }

    /**
     * @param int $port
     *
     * @throws Exception
     * @throws SmartyException
     */
    public function build_content($port): void
    {

        $smarty_coo = $this->smarty_vhost;

        $smarty_coo->assign('vhosts_array', $this->hosts_array);
        $smarty_coo->assign('port', $port);

        $this->content = $smarty_coo->fetch($this->smarty_tpl);
    }

    public function write_content_to_vhost_file(): void
    {

        $fh = fopen($this->vhost_file_path, 'wb+');
        fwrite($fh, $this->content);
        fclose($fh);
    }

    /**
     * @param Hostlist $host_list_coo
     */
    public function addHostList(Hostlist $host_list_coo): void
    {

        $hostListAsArray = $host_list_coo->get_host_list_array();

        /** @var Host $host */
        foreach ($hostListAsArray as $host) {
            $this->add_host($host);
        }


    }

    /**
     * @param Host $host_coo
     *
     */
    public function add_host(Host $host_coo): void
    {

        $this->hosts_array[] = $host_coo;
    }
}