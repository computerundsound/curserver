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
use app\ajaxresponse\ResponseDeleteBackupFile;
use computerundsound\culibrary\CuConstantsContainer;
use Exception;
use RuntimeException;


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
    public function __construct($pathToMySqlBackupFile, $mysqlUser, $mysqlPassword)
    {

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
    public static function makeGoodPath($path, $forcedDirectorySeparator = DIRECTORY_SEPARATOR, $isFileOrDir = true)
    {


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
    public static function getInstance(CuConstantsContainer $constant_container_coo,
                                       $mysqlDumpFilePathFromAppRoot)
    {

        $pathToMysqlBackupFile = $constant_container_coo->getAppRootServer() . $mysqlDumpFilePathFromAppRoot;

        $pathToMysqlBackupFile = self::makeGoodPath($pathToMysqlBackupFile, '/', false);

        return new self($pathToMysqlBackupFile, DB_USER_ROOT, DB_PW_ROOT);

    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function dumpMysql()
    {

        try {

            $mysqlDumperPath = $this->getMysqlDumperPath();

            $ajaxResponse = $this->dumpToFile($mysqlDumperPath);

        } catch (Exception $exception) {
            $ajaxResponse = new ResponseCreateDBBackup(true, $exception->getMessage(), '');
        }


        return $ajaxResponse;

    }

    /**
     * @return ResponseDeleteBackupFile
     */
    public function deleteFile()
    {

        if ($this->checkMysqlBackupExists()) {
            /** @noinspection PhpUsageOfSilenceOperatorInspection */
            $success      = @unlink($this->pathToMySqlBackupFile);
            $errorMessage = "Can't delete Backup-file in " . $this->pathToMySqlBackupFile;
        } else {
            $errorMessage = 'No Backup-file found in ' . $this->pathToMySqlBackupFile;
            $success      = false;
        }

        $ajaxResponse = new ResponseDeleteBackupFile(!$success, $errorMessage);

        return $ajaxResponse;


    }

    /**
     * @return bool
     */
    public function checkMysqlBackupExists()
    {

        $fileExists = (file_exists($this->pathToMySqlBackupFile) && is_file($this->pathToMySqlBackupFile));


        return $fileExists;

    }

    public function provideFile()
    {

        if (file_exists($this->pathToMySqlBackupFile)) {

            $fileSize = filesize($this->pathToMySqlBackupFile);

            header('Content-Type: application/sql');
            header('Content-Description: File Transfer');
            header('Content-Transfer-Encoding: text');
            header('Content-Disposition: attachment; filename="mysqlBackup.sql"');
            header("Content-Length: $fileSize");
            readfile($this->pathToMySqlBackupFile);
        }
    }

    /**
     * @return ResponseCreateDBBackup
     */
    public function restoreMySqlDatabase()
    {

        try {

            $mysqlExe = $this->getMysqlPath();

            $passwordElement = $this->mysqlPassword !== '' ? ' -p ' . $this->mysqlPassword : '';

            $execution = $mysqlExe .
                         ' -u ' .
                         $this->mysqlUser .
                         $passwordElement .
                         ' < ' .
                         $this->pathToMySqlBackupFile;

            exec($execution, $output, $return);

            $hasError = $return !== 0;

            $output = (array)$output;

            if (count($output) === 0) {
                $output = ['Error execute database-restore command'];
            }

            $errorMessage = implode("\n", $output);
            $errorMessage = trim($errorMessage);

            $ajaxResponse = new ResponseCreateDBBackup($hasError, $errorMessage, $this->pathToMySqlBackupFile);
        } catch (Exception $exception) {
            $ajaxResponse = new ResponseCreateDBBackup(true, 'Error restoring Database', $this->pathToMySqlBackupFile);
        }

        return $ajaxResponse;


    }

    /**
     *
     * @return string
     * @throws RuntimeException
     */
    protected function getMysqlDumperPath()
    {

        $pathToMysqlDump = $this->getPathFromMysqlBin('mysqldump.exe');

        return $pathToMysqlDump;
    }

    /**
     * @return string
     */
    protected function getPhpInfoContent()
    {

        ob_clean();
        ob_start();

        phpinfo();

        $content = ob_get_contents();
        ob_end_clean();


        return $content;
    }

    /**
     * @param string $fileName
     *
     * @return string
     *
     * @throws RuntimeException
     */
    private function getPathFromMysqlBin($fileName)
    {

        $pattern        = ';Server Root </td><td[^>]*>([^<]*);i';
        $phpInfoContent = $this->getPhpInfoContent();

        preg_match($pattern, $phpInfoContent, $matches);

        $match = (string)is_array($matches) && array_key_exists(1, $matches) ? $matches[1] : '';

        $match = trim($match);

        $pathToFile = $match . '/../mysql/bin/' . $fileName;

        $pathToFile = self::makeGoodPath($pathToFile, '/');

        if (is_string($pathToFile) === false || file_exists($pathToFile) === false) {

            throw new RuntimeException('Error searching for ' . $fileName);

        }

        return $pathToFile;
    }

    /**
     * @param string $mysqlDumperPath
     *
     * @return ResponseCreateDBBackup
     */
    private function dumpToFile($mysqlDumperPath)
    {

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
     * @return string
     * @throws RuntimeException
     */
    private function getMysqlPath()
    {

        $mysqlExe = $this->getPathFromMysqlBin('mysql.exe');

        return $mysqlExe;

    }

}
