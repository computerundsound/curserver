<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 18:39
 *
 * Created by IntelliJ IDEA
 *
 * Filename: Host.php
 */

namespace app\hostfile;

/**
 * Class Host
 *
 * @package app\hostfile
 */
class Host
{

    public static $fields_from_post_for_db_array
        = [
            'host_id',
            'tld',
            'domain',
            'subdomain',
            'ip',
            'comment',
            'vhost_dir',
            'vhost_htdocs',
        ];
    private       $host_id;
    private       $tld;
    private       $domain;
    private       $subdomain;
    private       $ip;
    private       $comment;
    private       $last_change;
    private       $vhost_dir;
    private       $vhost_htdocs;

    /**
     * @param $dir
     *
     * @return mixed
     */
    private static function make_vhost_dir($dir)
    {

        $dir = str_replace('\\', '/', $dir);

        return $dir;
    }

    /**
     * @param $host_id
     * @param $tld
     * @param $domain
     * @param $subDomain
     * @param $ip
     * @param $comment
     * @param $last_change
     * @param $vhost_dir
     * @param $vhost_htdocs
     */
    public function set_host($host_id,
                             $tld,
                             $domain,
                             $subDomain,
                             $ip,
                             $comment,
                             $last_change,
                             $vhost_dir,
                             $vhost_htdocs): void
    {

        $this->host_id      = $host_id;
        $this->tld          = $tld;
        $this->domain       = $domain;
        $this->subdomain    = $subDomain;
        $this->ip           = $ip;
        $this->comment      = $comment;
        $this->last_change  = $last_change;
        $this->vhost_dir    = self::make_vhost_dir($vhost_dir);
        $this->vhost_htdocs = self::make_vhost_dir($vhost_htdocs);
    }

    /**
     * @return mixed|string
     */
    public function getFullDomain()
    {

        $full_domain = '';

        if ($this->subdomain !== '') {
            $full_domain .= $this->subdomain . '.';
        }

        if ($this->domain !== '') {
            $full_domain .= $this->domain . '.';
        }

        if ($this->tld !== '') {
            $full_domain .= $this->tld;
        }

        $full_domain = str_replace(['..', '.'], '.', $full_domain);

        if ($full_domain[strlen($full_domain) - 1] === '.') {
            $full_domain = substr($full_domain, 0, -1);
        }

        return $full_domain;
    }


    /**
     * @return mixed
     */
    public function getComment()
    {

        return $this->comment;
    }


    /**
     * @return mixed
     */
    public function getDomain()
    {

        return $this->domain;
    }


    /**
     * @return mixed
     */
    public function getHostId()
    {

        return $this->host_id;
    }


    /**
     * @return mixed
     */
    public function getIp()
    {

        return $this->ip;
    }


    /**
     * @return mixed
     */
    public function getLastChange()
    {

        return $this->last_change;
    }


    public function set_last_change(): void
    {

        $date_time         = date('Y-m-d H-i-s');
        $this->last_change = $date_time;
    }


    /**
     * @return mixed
     */
    public function getSubdomain()
    {

        return $this->subdomain;
    }


    /**
     * @return mixed
     */
    public function getTld()
    {

        return $this->tld;
    }


    /**
     * @return mixed
     */
    public function getVhostDir()
    {

        return $this->vhost_dir;
    }


    /**
     * @return mixed
     */
    public function getVhostHtdocs()
    {

        return $this->vhost_htdocs;
    }
}