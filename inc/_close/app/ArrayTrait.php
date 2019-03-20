<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.21 at 00:43 MEZ
 */

namespace app;


/**
 * Class ArrayTrait
 *
 * @package app
 */
trait ArrayTrait
{

    /**
     * @param string $key
     * @param array  $array
     * @param string $default
     *
     * @return mixed|string
     */
    protected static function getValueFromArray(string $key, array $array, $default = '')
    {

        $value = array_key_exists($key, $array) ? $array[$key] : $default;

        return $value;


    }


}