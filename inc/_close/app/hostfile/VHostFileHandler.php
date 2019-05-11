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

    private $hostsArray = [];
    /**
     * @var Smarty
     */
    private $smartyVhost;
    private $smartyTpl;

    private $content;
    private $vhostFilePath;


    /**
     * @param Smarty|MakeView $smartyVhost
     * @param string          $smartyTpl
     * @param string          $vhostFilePath
     */
    public function __construct(MakeView $smartyVhost, $smartyTpl, $vhostFilePath)
    {

        $this->smartyVhost   = $smartyVhost;
        $this->smartyTpl     = $smartyTpl;
        $this->vhostFilePath = $vhostFilePath;
    }

    public function createFileIfNotExist()
    {

        touch($this->vhostFilePath);
    }

    /**
     * @param int $port
     *
     * @throws Exception
     * @throws SmartyException
     */
    public function buildContent($port)
    {

        $smarty_coo = $this->smartyVhost;

        $smarty_coo->assign('vhosts_array', $this->hostsArray);
        $smarty_coo->assign('port', $port);

        $this->content = $smarty_coo->fetch($this->smartyTpl);
    }

    public function writeContentToVhostFile()
    {

        if ($this->vhostFilePath) {
            $fh = fopen($this->vhostFilePath, 'wb+');
            fwrite($fh, $this->content);
            fclose($fh);
        }
    }

    /**
     * @param HostList $hostList
     */
    public function addHostList(HostList $hostList)
    {

        $hostListAsArray = $hostList->getHostListArray();

        /** @var Host $host */
        foreach ($hostListAsArray as $host) {
            $this->add_host($host);
        }


    }

    /**
     * @param Host $hostCoo
     *
     */
    public function add_host(Host $hostCoo)
    {

        $this->hostsArray[] = $hostCoo;
    }
}