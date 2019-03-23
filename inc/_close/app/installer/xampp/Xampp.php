<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 22:59 MEZ
 */

namespace app\installer\xampp;


use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use app\installer\modifier\ModifyPHPIni;
use app\installer\Replacer\Replacer;

/**
 * Class Xampp
 *
 * @package app\installer
 */
class Xampp
{
    /**
     * @var string
     */
    protected $xamppDir;
    /**
     * @var ModifyMysqlIni
     */
    protected $modifyMysqlIni;
    /**
     * @var ModifyConfVHost
     */
    protected $modifyConfVHost;
    /**
     * @var ModifyPHPIni
     */
    protected $modifyPHPIni;


    /**
     * Xampp constructor.
     *
     * @param string          $xamppDir
     * @param ModifyMysqlIni  $modifyMysqlIni
     * @param ModifyConfVHost $modifyConfVHost
     * @param ModifyPHPini    $modifyPHPIni
     */
    public function __construct(string $xamppDir,
                                ModifyMysqlIni $modifyMysqlIni,
                                ModifyConfVHost $modifyConfVHost,
                                ModifyPHPIni $modifyPHPIni)
    {

        $this->xamppDir        = $xamppDir;
        $this->modifyMysqlIni  = $modifyMysqlIni;
        $this->modifyConfVHost = $modifyConfVHost;
        $this->modifyPHPIni    = $modifyPHPIni;
    }

    /**
     * @return string
     */
    public function getXamppDir(): string
    {

        return $this->xamppDir;
    }

    /**
     * @return string
     */
    public function getXamppDirName(): string
    {

        return basename($this->xamppDir);

    }

    /**
     * @param Replacer $replacer
     */
    public function update(Replacer $replacer): void
    {

        $this->modifyConfVHost->modify($replacer->getVhostReplacer());
        $this->modifyMysqlIni->modify($replacer->getMysqlIniReplacer());
        $this->modifyPHPIni->modify($replacer->getPhpIniReplacer());

    }


}