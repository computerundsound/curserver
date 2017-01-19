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
 * @package viewer
 */

namespace viewer;

use computerundsound\culibrary\CuString;

/**
 * Class MakeView
 *
 * @package viewer
 */

/** @noinspection LongInheritanceChainInspection */
class MakeView extends \Smarty {

    /**
     * @var
     */
    private        $smarty_dir;
    private static $smarty_dirs_not_provided
        = [
            'templates',
            'templates_c',
            'configs',
            'cache',
        ];

    /**
     * MakeView constructor.
     *
     * @param $smartyDir
     */
    public function __construct($smartyDir) {

        $this->smarty_dir = $smartyDir;

        $this->test_and_create_smarty_dirs();

        parent::__construct();

        $this->setTemplateDir($smartyDir . 'templates/');
        $this->setCompileDir($smartyDir . 'templates_c/');
        $this->setConfigDir($smartyDir . 'configs/');
        $this->setCacheDir($smartyDir . 'cache/');

        if (CU_DEBUG_MODUS) {
            $this->caching = false;
            $this->clearAllCache(true);
        }

    }

    /**
     *
     */
    private function test_and_create_smarty_dirs() {

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
     */
    private function mkDir($dirname) {

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $result = @mkdir($dirname);

        return $result;
    }


}