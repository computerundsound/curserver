<?php


namespace app\vhost;


class VHostFiles
{

    protected $vHost;

    /**
     * VHostFile constructor.
     *
     * @param string $vHostSerialized
     */
    public function __construct($vHostSerialized = VHOST_FILES)
    {

        $this->vHost = unserialize($vHostSerialized);
    }

    public function getVHostFileName($xamppVersion)
    {

        $vHostFileName = $this->vHost['VHOST_FILE_IF_VERSION_IS_GREATER_OR_EQUAL_THAN_5_4']['templateName'];

        if (version_compare($xamppVersion, '5.4', '<=')) {

            $vHostFileName = $this->vHost['VHOST_FILE_IF_VERSION_IS_SMALLER_THAN_5_4']['templateName'];
        }

        if (version_compare($xamppVersion, '5', '<')) {

            $vHostFileName = $this->vHost['VHOST_FILE_IF_VERSION_IS_SMALLER_THAN_5']['templateName'];
        }


        return $vHostFileName;

    }

    public function getAllVHostFiles()
    {

        return $this->vHost;
    }

}