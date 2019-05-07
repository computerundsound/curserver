<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 16.06.2014
 * Time: 00:41
 *
 * Created by IntelliJ IDEA
 *
 * Filename: Hostfilehandler.php
 */

/**
 * Class Hostfilehandler
 *
 * @package app\hostfile
 */

namespace app\hostfile;

use computerundsound\culibrary\CuRequester;

/**
 * Class Hostfilehandler
 *
 * @package app\hostfile
 */
class HostFileHandler
{

    private static $hostfile_separator = '# ************ Next content is from curServer ************';
    private        $pathToHostfile;
    private        $hosts_array        = []; // Host
    private        $prefix;

    private $hostFileContent;


    /**
     * @param $pathToHostfile
     */
    public function __construct($pathToHostfile)
    {

        $this->pathToHostfile = $pathToHostfile;

        $this->buildHostPrefix();
    }

    /**
     * @param      $prefix
     * @param bool $getId
     *
     * @return array
     */
    public static function getPostDataAsArray($prefix, $getId = true)
    {

        $data_array               = [];
        $fieldsFromPostForDbArray = [
            Host::FieldName_subdomain,
            Host::FieldName_domain,
            Host::FieldName_tld,
            Host::FieldName_vhost_dir,
            Host::FieldName_vhost_htdocs,
            Host::FieldName_comment,
            Host::FieldName_ip,

        ];

        foreach ($fieldsFromPostForDbArray as $field_name) {
            if ($getId === false && $field_name === 'host_id') {
                continue;
            }
            $val = CuRequester::getGetPost($prefix . $field_name);
            if ('vhost_dir' === $field_name || 'vhost_htdocs' === $field_name) {
                $val = str_replace('\\', '/', $val);
            }

            $count = 1;
            while ($count > 0) {
                $val = str_replace('//', '/', $val, $count);
            }

            $data_array[$field_name] = $val;
        }

        return $data_array;
    }

    /**
     * @return mixed
     */
    public function getPathToHostfile()
    {

        return $this->pathToHostfile;
    }

    public function buildHostContent()
    {

        $hostContent = $this->prefix;
        $hostContent .= self::$hostfile_separator . PHP_EOL . PHP_EOL;

        /** @var Host $host */
        foreach ($this->hosts_array as $host) {
            $hostContent .= $host->getIp() . "\t" . $host->getFullDomain() . PHP_EOL;
        }

        $this->hostFileContent = $hostContent;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {

        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getHostFileContent()
    {

        return $this->hostFileContent;
    }

    /**
     * @param HostList $hostList
     */
    public function addHostList(HostList $hostList)
    {

        $hostListArray = $hostList->getHostListArray();

        /** @var Host[] $hostListArray */
        foreach ($hostListArray as $host) {
            $this->addHost($host);
        }

    }

    /**
     * @param Host $host
     */
    public function addHost(Host $host)
    {

        $this->hosts_array[] = $host;
    }

    private function buildHostPrefix()
    {

        $host_content                = file_get_contents($this->pathToHostfile);
        $host_content_elements_array = explode(self::$hostfile_separator, $host_content);
        $this->prefix                = $host_content_elements_array[0];
    }
}