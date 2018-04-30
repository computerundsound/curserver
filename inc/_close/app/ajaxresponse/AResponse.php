<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.29 at 03:16 MESZ
 */

/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 29.04.2018
 * Time: 03:16
 * 
 * Created by PhpStorm
 *
 */

namespace app\ajaxresponse;


/**
 * Class AResponse
 *
 * @package app\ajaxresponse
 */
abstract class AResponse
{
    /** @var string */
    protected $errorMessage;
    /** @var bool */
    protected $hasError;

    /**
     * ResponseCreateDBBackup constructor.
     *
     * @param bool   $hasError
     * @param string $errorMessage
     */
    public function __construct($hasError, $errorMessage) {
        $this->hasError     = $hasError;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return bool
     */
    public function getHasError() {
        return $this->hasError;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }

    abstract public function showAsJson();

    /**
     * @param array $jsonArray
     */
    protected function sendJsonToBrowser(array $jsonArray) {
        header('Content-Type: application/json');
        echo json_encode($jsonArray);
    }
}