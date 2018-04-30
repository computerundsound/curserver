<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.29 at 03:13 MESZ
 */

/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 29.04.2018
 * Time: 03:13
 * 
 * Created by PhpStorm
 *
 */

namespace app\ajaxresponse;


/**
 * Class ResponseCreateDBBackup
 *
 * @package app\ajaxresponse
 */
class ResponseCreateDBBackup extends AResponse
{


    /** @var string */
    protected $fileUrl;


    /** @noinspection MagicMethodsValidityInspection */
    /** @noinspection PhpMissingParentConstructorInspection */

    /***
     * ResponseCreateDBBackup constructor.
     *
     * @param bool   $hasError
     * @param string $errorMessage
     * @param string $fileUrl
     */
    public function __construct($hasError, $errorMessage, $fileUrl) {
        $this->hasError     = $hasError;
        $this->errorMessage = $errorMessage;
        $this->fileUrl      = $fileUrl;
    }


    /**
     * @return string
     */
    public function getFileUrl() {
        return $this->fileUrl;
    }

    public function showAsJson() {
        $jsonArray = [
            'hasError'     => $this->hasError,
            'errorMessage' => $this->errorMessage,
            'fileUrl'      => $this->fileUrl,

        ];

        $this->sendJsonToBrowser($jsonArray);

    }


}