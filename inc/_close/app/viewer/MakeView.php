<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 16.06.2014
 * Time: 00:46
 *
 * Created by IntelliJ IDEA
 *
 * Filename: MakeView.php
 */

/**
 * Class MakeView
 *
 * @package app\viewer
 */

namespace app\viewer;

use computerundsound\culibrary\CuString;
use RuntimeException;
use Smarty;

/**
 * Class MakeView
 *
 * @package viewer
 */
/** @noinspection LongInheritanceChainInspection */

class MakeView extends Smarty
{

    private static $smarty_dirs_not_provided
        = [
            'templates',
            'templates_c',
            'configs',
            'cache',
        ];
    /**
     * @var
     */
    private $smarty_dir;

    /**
     * MakeView constructor.
     *
     * @param $smartyDir
     *
     * @throws RuntimeException
     */
    public function __construct($smartyDir)
    {

        $this->smarty_dir = $smartyDir;

        $this->test_and_create_smarty_dirs();

        parent::__construct();

        $this->setTemplateDir($smartyDir . 'templates/');
        $this->setCompileDir($smartyDir . 'templates_c/');
        $this->setConfigDir($smartyDir . 'configs/');
        $this->setCacheDir($smartyDir . 'cache/');

        if (CU_DEBUG_MODE) {
            $this->caching = false;
            $this->clearAllCache(true);
        }

    }

    /**
     *
     * @throws RuntimeException
     */
    private function test_and_create_smarty_dirs()
    {

        $error = false;

        foreach (self::$smarty_dirs_not_provided as $dir) {
            if (is_dir($this->smarty_dir . $dir) === false) {
                $result = $this->mkDir($this->smarty_dir . $dir);
                if ($result === false) {
                    $error = true;
                }
            }
        }

        if ($error === true) {

            $errormsg = '';

            foreach (self::$smarty_dirs_not_provided as $dir) {
                if ($dir === 'templates') {
                    continue;
                }
                $errormsg .= " $dir,";
            }
            $errormsg = CuString::killLastSign($errormsg);

            $errormsg
                = 'Please create the following directories in ' .
                  $this->smarty_dir .
                  ': <br>' .
                  $errormsg .
                  '<br>' .
                  'Make sure that the directories are writable (0777)';
            die($errormsg);

        }
    }

    /**
     * @param $dirname
     *
     * @return bool
     * @throws RuntimeException
     */
    private function mkDir($dirname)
    {

        if (!mkdir($dirname) && !is_dir($dirname)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dirname));
        }

        return true;
    }


}