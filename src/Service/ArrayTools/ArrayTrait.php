<?php
declare(strict_types=1);

namespace App\Service\ArrayTools;

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
    protected static function getValueFromArray($key, array $array, $default = '')
    {

        $value = array_key_exists($key, $array) ? $array[$key] : $default;

        return $value;


    }


}