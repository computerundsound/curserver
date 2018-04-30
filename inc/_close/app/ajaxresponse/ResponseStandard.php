<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.30 at 06:13 MESZ
 */

/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.04.2018
 * Time: 06:13
 * 
 * Created by PhpStorm
 *
 */

namespace app\ajaxresponse;


/**
 * Class ResponseStandard
 *
 * @package app\ajaxresponse
 */
class ResponseStandard extends AResponse
{
    public function showAsJson() {

        $array = [

            'hasError'     => $this->getHasError(),
            'errorMessage' => $this->getErrorMessage(),
        ];

        $this->sendJsonToBrowser($array);


    }


}