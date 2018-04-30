<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.29 at 01:09 MESZ
 */

/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 29.04.2018
 * Time: 01:09
 * 
 * Created by PhpStorm
 *
 */

namespace app\mysql_dumper;

use app\ajaxresponse\ResponseCreateDBBackup;
use computerundsound\culibrary\CuConstantsContainer;


/**
 * Class CuMysqlDump
 *
 * @package app\mysql_dumper
 */
class CuMysqlDump
{
    /**
     * @var string
     */
    protected $pathToMySqlBackupFile;
    /**
     * @var string
     */
    protected $mysqlUser;
    /**
     * @var string
     */
    protected $mysqlPassword;


    /**
     * CuMysqlDump constructor.
     *
     * @param string $pathToMySqlBackupFile
     * @param string $mysqlUser
     * @param string $mysqlPassword
     */
    public function __construct($pathToMySqlBackupFile, $mysqlUser, $mysqlPassword) {

        $this->pathToMySqlBackupFile = self::makeGoodPath($pathToMySqlBackupFile, '/', false);
        $this->mysqlUser             = $mysqlUser;
        $this->mysqlPassword         = $mysqlPassword;
    }

    /**
     * @param string $path
     * @param string $forcedDirectorySeparator
     * @param bool   $isFileOrDir
     *
     * @return bool|null|string|string[]
     */
    public static function makeGoodPath($path, $forcedDirectorySeparator = DIRECTORY_SEPARATOR, $isFileOrDir = true) {


        if ($isFileOrDir) {
            $path = realpath($path);
        }

        $path = preg_replace(';[/\\\]+;', $forcedDirectorySeparator, $path);

        return $path;
    }

    /**
     * @param CuConstantsContainer $constant_container_coo
     * @param string               $mysqlDumpFilePathFromAppRoot
     *
     * @return CuMysqlDump
     */
    public static function getInstance(CuConstantsContainer $constant_container_coo, $mysqlDumpFilePathFromAppRoot) {
        $pathToMysqlBackupFile = $constant_container_coo->getAppRootServer() . $mysqlDumpFilePathFromAppRoot;

        $pathToMysqlBackupFile = self::makeGoodPath($pathToMysqlBackupFile, '/', false);

        return new self($pathToMysqlBackupFile, DB_USER_ROOT, DB_PW_ROOT);

    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function dumpMysql() {

        try {

            $phpInfoContent  = $this->getPhpInfoContent();
            $mysqlDumperPath = $this->getMysqlDumperPath($phpInfoContent);


            $ajaxResponse = $this->dumpToFile($mysqlDumperPath);

        } catch (\Exception $exception) {
            $ajaxResponse = new ResponseCreateDBBackup(true, $exception->getMessage(), '');
        }


        return $ajaxResponse;

    }

    /**
     * @return string
     */
    protected function getPhpInfoContent() {

        ob_clean();
        ob_start();

        phpinfo();

        $content = ob_get_contents();
        ob_end_clean();


        return $content;
    }

    /**
     * @param string $phpInfoContent
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getMysqlDumperPath($phpInfoContent) {
        $pattern = ';Server Root </td><td[^>]*>([^<]*);i';

        preg_match($pattern, $phpInfoContent, $matches);

        $match = (string)is_array($matches) && array_key_exists(1, $matches) ? $matches[1] : '';

        $match = trim($match);

        $pathToMysqlDump = $match . '/../mysql/bin/mysqldump.exe';

        $pathToMysqlDump = self::makeGoodPath($pathToMysqlDump, '/');

        if (is_string($pathToMysqlDump) && file_exists($pathToMysqlDump) === false) {

            throw new \RuntimeException('Error searching for mysqldump.exe');

        }


        return $pathToMysqlDump;
    }

    /**
     * @param string $mysqlDumperPath
     *
     * @return ResponseCreateDBBackup
     */
    private function dumpToFile($mysqlDumperPath) {

        $passwordElement = $this->mysqlPassword !== '' ? ' -p ' . $this->mysqlPassword : '';

        $execution = $mysqlDumperPath .
                     ' -u ' .
                     $this->mysqlUser .
                     $passwordElement .
                     ' --all-databases > ' .
                     $this->pathToMySqlBackupFile;

        exec($execution, $output, $return);

        $hasError = $return !== 0;

        $output = (array)$output;

        $errorMessage = print_r($output, true);
        $errorMessage = trim($errorMessage);

        $ajaxResponse = new ResponseCreateDBBackup($hasError, $errorMessage, $this->pathToMySqlBackupFile);

        return $ajaxResponse;


    }

    /**
     * @return bool
     */
    public function checkMysqlBackupExists() {

        $fileExists = (file_exists($this->pathToMySqlBackupFile) && is_file($this->pathToMySqlBackupFile));


        return $fileExists;

    }
}