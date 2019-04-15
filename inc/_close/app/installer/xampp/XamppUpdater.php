<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 17:20 MEZ
 */

namespace app\installer\xampp;


use app\installer\modifier\ModifyConfVHost;
use app\installer\modifier\ModifyMysqlIni;
use app\installer\modifier\ModifyPHPIni;
use app\installer\Replacer\Replacer;

/**
 * Class XamppUpdater
 *
 * @package app\installer\xampp
 */
class XamppUpdater
{
    /**
     * @var Xampp
     */
    protected $xampp;
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
     * @var string
     */
    protected $appRootDir;

    /**
     * XamppUpdater constructor.
     *
     * @param Xampp           $xampp
     * @param ModifyMysqlIni  $modifyMysqlIni
     * @param ModifyConfVHost $modifyConfVHost
     * @param ModifyPHPIni    $modifyPHPIni
     * @param string          $appRootDir
     */
    public function __construct(Xampp $xampp,
                                ModifyMysqlIni $modifyMysqlIni,
                                ModifyConfVHost $modifyConfVHost,
                                ModifyPHPIni $modifyPHPIni,
                                string $appRootDir)
    {

        $this->xampp           = $xampp;
        $this->modifyMysqlIni  = $modifyMysqlIni;
        $this->modifyConfVHost = $modifyConfVHost;
        $this->modifyPHPIni    = $modifyPHPIni;
        $this->appRootDir      = $appRootDir;
    }


    /**
     * @param Replacer $replacer
     */
    public function update(Replacer $replacer): void
    {

        $this->modifyConfVHost->modify($replacer->getVhostReplacer());
        $this->modifyMysqlIni->modify($replacer->getMysqlIniReplacer());
        $this->xdebug($replacer);
        $this->modifyPHPIni->modify($replacer->getPhpIniReplacer());


    }

    /**
     * @param Replacer $replacer
     */
    protected function xdebug(Replacer $replacer): void
    {

        $xdebugDllPath = realpath($this->xampp->getXamppDir() . '/php/ext/php_xdebug.dll');

        if ($xdebugDllPath) {
            $this->modifyPHPIni->addXDebug($replacer, $this->appRootDir);
        }
    }


}