<?php
declare(strict_types=1);

namespace App\Service\Hostfile;

use DateTime;
use Exception;
use JsonSerializable;

class Host implements JsonSerializable
{

    public const FIELD_NAME_ID           = 'id';
    public const FIELD_NAME_SUBDOMAIN    = 'subdomain';
    public const FIELD_NAME_DOMAIN       = 'domain';
    public const FIELD_NAME_TLD          = 'tld';
    public const FIELD_NAME_IP           = 'ip';
    public const FIELD_NAME_COMMENT      = 'comment';
    public const FIELD_NAME_VHOST_DIR    = 'vhost_dir';
    public const FIELD_NAME_VHOST_HTDOCS = 'vhost_htdocs';
    public const FIELD_NAME_LAST_CHANGE  = 'last_change';


    private ?int      $hostId       = null;
    private string   $tld          = '';
    private string   $domain       = '';
    private string   $subdomain    = '';
    private string   $ip           = '';
    private string   $comment      = '';
    private DateTime $last_change;
    private string   $vhost_dir    = '';
    private string   $vhost_htdocs = '';

    public static function createFromArray(array $data): Host
    {

        $host = new self();
        $host->setSubdomain($data['subdomain'] ?: '');
        $host->setDomain($data['domain'] ?: '');
        $host->setTld($data['tld'] ?: '');
        $host->setComment($data['comment'] ?: '');
        $host->setVhostDir($data['directory'] ?: '');
        $host->setVhostHtdocs($data['document_root'] ?: '');
        $host->setIp($data['ip'] ?: '');

        if (isset($data['id'])) {
            $id = (int)$data['id'];
            $host->setId($id);
        }

        return $host;

    }

    /**
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
        $vhost_htdocs): Host
    {

        $this->hostId       = $host_id;
        $this->tld          = $tld;
        $this->domain       = $domain;
        $this->subdomain    = $subDomain;
        $this->ip           = $ip;
        $this->comment      = $comment;
        $this->last_change  = $last_change;
        $this->vhost_dir    = $this->makeVhostDir($vhost_dir);
        $this->vhost_htdocs = $this->makeVhostDir($vhost_htdocs);

        return $this;
    }

    public function getFullDomain(): string
    {

        $fullDomain = '';

        if ('' !== $this->subdomain) {
            $fullDomain .= $this->subdomain . '.';
        }

        if ('' !== $this->domain) {
            $fullDomain .= $this->domain . '.';
        }

        if ('' !== $this->tld) {
            $fullDomain .= $this->tld;
        }

        $fullDomain = str_replace(['..', '.'], '.', $fullDomain);

        if (strlen($fullDomain) > 1 && '.' === $fullDomain[strlen($fullDomain) - 1]) {
            $fullDomain = substr($fullDomain, 0, -1);
        }

        return $fullDomain;
    }

    public function getComment(): string
    {

        return $this->comment;
    }


    public function getDomain(): string
    {

        return $this->domain;
    }


    public function getId(): ?int
    {

        return $this->hostId;
    }


    public function getIp(): string
    {

        return $this->ip;
    }

    /**
     * @throws Exception
     */
    public function getLastChange(): DateTime
    {

        return $this->last_change;
    }


    public function getSubdomain(): string
    {

        return $this->subdomain;
    }


    public function getTld(): string
    {

        return $this->tld;
    }

    public function getVhostDir(): string
    {

        return $this->vhost_dir;
    }

    public function getVhostHtdocs(): string
    {

        return $this->vhost_htdocs;
    }

    public function setHostId(int $hostId): Host
    {

        $this->hostId = $hostId;

        return $this;
    }


    public function setTld(string $tld): Host
    {

        $this->tld = $tld;

        return $this;
    }

    public function setDomain($domain): Host
    {

        $this->domain = $domain;

        return $this;
    }

    public function setSubdomain(string $subdomain): Host
    {

        $this->subdomain = $subdomain;

        return $this;
    }


    public function setIp(string $ip): Host
    {

        $this->ip = $ip;

        return $this;
    }

    public function setComment(string $comment): Host
    {

        $this->comment = $comment;

        return $this;
    }

    public function setVhostDir(string $vhostDir): Host
    {

        $this->vhost_dir = $vhostDir;

        return $this;
    }

    public function setVhostHtdocs(string $vhostHtdocs): Host
    {

        $this->vhost_htdocs = $vhostHtdocs;

        return $this;
    }


    public function setLastChange(DateTime $lastChange): Host
    {

        $this->last_change = $lastChange;

        return $this;

    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @throws Exception
     */
    public function jsonSerialize(): array
    {

        return [
            self::FIELD_NAME_ID           => $this->getId(),
            self::FIELD_NAME_SUBDOMAIN    => $this->getSubdomain(),
            self::FIELD_NAME_DOMAIN       => $this->getDomain(),
            self::FIELD_NAME_TLD          => $this->getTld(),
            self::FIELD_NAME_IP           => $this->getIp(),
            self::FIELD_NAME_COMMENT      => $this->getComment(),
            self::FIELD_NAME_VHOST_DIR    => $this->getVhostDir(),
            self::FIELD_NAME_VHOST_HTDOCS => $this->getVhostHtdocs(),
            self::FIELD_NAME_LAST_CHANGE  => $this->getLastChange()->format('Y-m-d H:i:s'),

        ];
    }

    public function setId(int $id): Host
    {

        $this->hostId = $id;

        return $this;
    }

    private function makeVhostDir(string $dir): string
    {

        return str_replace('\\', '/', $dir);

    }
}