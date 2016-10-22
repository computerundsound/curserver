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
 * @package hostfile
 */

namespace hostfile;

use computerundsound\culibrary\CuNet;

/**
 * Class Hostfilehandler
 *
 * @package hostfile
 */
class Hostfilehandler {

    private static $hostfile_separator = '# ************ Next content is from curServer ************';
    private        $path_to_hostfile;
    private        $hosts_array        = []; // Host
    private        $prefix;

    private $host_file_content;


    /**
     * @param $path_to_hostfile
     */
    public function __construct($path_to_hostfile) {
        $this->path_to_hostfile = $path_to_hostfile;

        $this->build_host_prefix();
    }


    /**
     * @param      $p_prefix
     * @param bool $p_get_id
     *
     * @return array
     */
    public static function get_post_data_as_array($p_prefix, $p_get_id = true) {
        $data_array = [];
        foreach (Host::$fields_from_post_for_db_array as $field_name) {
            if ($p_get_id === false && $field_name === 'host_id') {
                continue;
            }
            $val = CuNet::get_post($p_prefix . $field_name);
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
    public function getPathToHostfile() {
        return $this->path_to_hostfile;
    }


    /**
     * @param \hostfile\Host $host_coo
     */
    public function add_host(Host $host_coo) {
        $this->hosts_array[] = $host_coo;
    }


    public function build_host_content() {
        $host_content = $this->prefix;
        $host_content .= self::$hostfile_separator . PHP_EOL  . PHP_EOL;

        /** @var Host $host */
        foreach ($this->hosts_array as $host) {
            $host_content .= $host->getIp() . "\t" . $host->getFullDomain() . PHP_EOL;
        }

        $this->host_file_content = $host_content;
    }


    /**
     * @return mixed
     */
    public function getPrefix() {
        return $this->prefix;
    }


    /**
     * @return mixed
     */
    public function getHostFileContent() {
        return $this->host_file_content;
    }


    private function build_host_prefix() {
        $host_content                = file_get_contents($this->path_to_hostfile);
        $host_content_elements_array = explode(self::$hostfile_separator, $host_content);
        $this->prefix                = $host_content_elements_array[0];
    }

    /**
     * @param \hostfile\Hostlist $host_list_coo
     */
    public function add_host_list(Hostlist $host_list_coo) {

        $hostListArray = $host_list_coo->get_host_list_array();

        /** @var Host $host */
        foreach ($hostListArray as $host) {
            $this->add_host($host);
        }

    }
}