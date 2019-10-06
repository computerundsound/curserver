<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 18:39
 *
 * Filename: Host.php
 */

namespace app\hostfile;

use DateTime;
use Exception;
use JsonSerializable;

/**
 * Class Host
 *
 * @package app\hostfile
 */
class Host implements JsonSerializable
{

    const FieldName_ID           = 'id';
    const FieldName_subdomain    = 'subdomain';
    const FieldName_domain       = 'domain';
    const FieldName_tld          = 'tld';
    const FieldName_ip           = 'ip';
    const FieldName_comment      = 'comment';
    const FieldName_vhost_dir    = 'vhost_dir';
    const FieldName_vhost_htdocs = 'vhost_htdocs';
    const FieldName_last_change  = 'last_change';


    private $hostId    = '';
    private $tld       = '';
    private $domain    = '';
    private $subdomain = '';
    private $ip        = '';
    private $comment   = '';
    /** @var DateTime */
    private $last_change;
    private $vhost_dir    = '';
    private $vhost_htdocs = '';

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
     * @param int      $host_id
     * @param string   $tld
     * @param string   $domain
     * @param string   $subDomain
     * @param string   $ip
     * @param string   $comment
     * @param DateTime $last_change
     * @param string   $vhost_dir
     * @param string   $vhost_htdocs
     *
     * @throws Exception
     */
    public function setHost($host_id,
                            $tld,
                            $domain,
                            $subDomain,
                            $ip,
                            $comment,
                            DateTime $last_change,
                            $vhost_dir,
                            $vhost_htdocs)
    {

        $this->hostId       = (int)$host_id;
        $this->tld          = (string)$tld;
        $this->domain       = (string)$domain;
        $this->subdomain    = (string)$subDomain;
        $this->ip           = (string)$ip;
        $this->comment      = (string)$comment;
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

        if (strlen($full_domain) > 1 && $full_domain[strlen($full_domain) - 1] === '.') {
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
     * @return int
     */
    public function getId()
    {

        return $this->hostId;
    }


    /**
     * @return mixed
     */
    public function getIp()
    {

        return $this->ip;
    }


    /**
     * @return DateTime
     * @throws Exception
     */
    public function getLastChange()
    {

        return $this->last_change ?: new DateTime();
    }


    public function set_last_change()
    {

        $date_time         = new DateTime();
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

    /**
     * @param mixed $hostId
     *
     * @return Host
     */
    public function setHostId($hostId)
    {

        $this->hostId = (int)$hostId;

        return $this;
    }

    /**
     * @param mixed $tld
     *
     * @return Host
     */
    public function setTld($tld)
    {

        $this->tld = (string)$tld;

        return $this;
    }

    /**
     * @param mixed $domain
     *
     * @return Host
     */
    public function setDomain($domain)
    {

        $this->domain = (string)$domain;

        return $this;
    }

    /**
     * @param mixed $subdomain
     *
     * @return Host
     */
    public function setSubdomain($subdomain)
    {

        $this->subdomain = (string)$subdomain;

        return $this;
    }

    /**
     * @param mixed $ip
     *
     * @return Host
     */
    public function setIp($ip)
    {

        $this->ip = (string)$ip;

        return $this;
    }

    /**
     * @param mixed $comment
     *
     * @return Host
     */
    public function setComment($comment)
    {

        $this->comment = (string)$comment;

        return $this;
    }

    /**
     * @param mixed $vhost_dir
     *
     * @return Host
     */
    public function setVhostDir($vhost_dir)
    {

        $this->vhost_dir = (string)$vhost_dir;

        return $this;
    }

    /**
     * @param mixed $vhost_htdocs
     *
     * @return Host
     */
    public function setVhostHtdocs($vhost_htdocs)
    {

        $this->vhost_htdocs = (string)$vhost_htdocs;

        return $this;
    }

    /**
     * @param DateTime $lastChange
     *
     * @return Host
     */
    public function setLastChange(DateTime $lastChange)
    {

        $this->last_change = $lastChange;

        return $this;

    }


    /**
     * Specify data which should be serialized to JSON
     *
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     * @throws Exception
     */
    public function jsonSerialize()
    {

        return [
            self::FieldName_ID           => $this->getId(),
            self::FieldName_subdomain    => $this->getSubdomain(),
            self::FieldName_domain       => $this->getDomain(),
            self::FieldName_tld          => $this->getTld(),
            self::FieldName_ip           => $this->getIp(),
            self::FieldName_comment      => $this->getComment(),
            self::FieldName_vhost_dir    => $this->getVhostDir(),
            self::FieldName_vhost_htdocs => $this->getVhostHtdocs(),
            self::FieldName_last_change  => $this->getLastChange()->format('Y-m-d H:i:s'),

        ];
    }

    public function setId($id)
    {

        $this->hostId = (int)$id;
    }
}