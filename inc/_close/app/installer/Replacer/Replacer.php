<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.20 at 23:14 MEZ
 */

namespace app\installer\Replacer;


/**
 * Class Replacer
 *
 * @package app\installer
 */
class Replacer
{

    protected $vhostReplacer    = [];
    protected $phpIniReplacer   = [];
    protected $phpIniExtend     = [];
    protected $mysqlIniReplacer = [];

    /**
     * Replacer constructor.
     *
     * @param array $vhostReplacer
     * @param array $phpIniReplacer
     * @param array $phpIniExtend
     * @param array $mysqlIniReplacer
     */
    public function __construct(array $vhostReplacer,
                                array $phpIniReplacer,
                                array $phpIniExtend,
                                array $mysqlIniReplacer)
    {

        $this->vhostReplacer    = $vhostReplacer;
        $this->phpIniReplacer   = $phpIniReplacer;
        $this->phpIniExtend     = $phpIniExtend;
        $this->mysqlIniReplacer = $mysqlIniReplacer;
    }

    /**
     * @return array
     */
    public function getVhostReplacer()
    {

        return $this->vhostReplacer;
    }

    /**
     * @return array
     */
    public function getPhpIniReplacer()
    {

        return $this->phpIniReplacer;
    }

    /**
     * @return array
     */
    public function getMysqlIniReplacer()
    {

        return $this->mysqlIniReplacer;
    }

    /**
     * @return array
     */
    public function getPhpIniExtend()
    {

        return $this->phpIniExtend;
    }

}