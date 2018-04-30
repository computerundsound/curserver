<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.29 at 03:25 MESZ
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
 * Class ResponseDeleteBackupFile
 *
 * @package app\ajaxresponse
 */
class ResponseDeleteBackupFile extends AResponse
{


    public function showAsJson() {
        $jsonArray = [
            'hasError'     => $this->hasError,
            'errorMessage' => $this->errorMessage,

        ];

        $this->sendJsonToBrowser($jsonArray);
    }


}