<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 19:34
 *
 * Created by IntelliJ IDEA
 *
 * Filename: Hostlist.php
 */


namespace app\hostfile;

/**
 * Class Hostlist
 *
 * @package app\hostfile
 */
class Hostlist
{

    public  $test            = ['a', 'b'];
    private $host_list_array = [];


    /**
     *
     */
    public function __construct()
    {

        $this->test = 'Das ist ein Test';
    }


    /**
     * @param Host $host_coo
     */
    public function add_host(Host $host_coo): void
    {

        $this->host_list_array[] = $host_coo;
    }


    /**
     * @return array
     */
    public function get_host_list_array(): array
    {

        return $this->host_list_array;
    }
}