<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 22:11 MEZ
 */

namespace app;


/**
 * Class Debug
 *
 * @package app
 */
class Debug
{

    /**
     * @param mixed $value
     * @param bool  $exit
     */
    public static function printHtml($value, $exit = false)
    {

        self::output($value, $exit, true);

    }

    /**
     * @param mixed $value
     * @param bool  $exit
     */
    public static function printText($value, $exit = false)
    {

        self::output($value, $exit, false);
    }

    /**
     * @param mixed $value
     * @param bool  $exit
     * @param bool  $isHtml
     */
    protected static function output($value, $exit, $isHtml)
    {

        $outputValue = is_array($value) ? $value : [$value];

        $outputString = print_r($outputValue, true);

        $output = $isHtml ? "<pre>$outputString</pre>" : $outputString;

        echo $output;

        if ($exit) {
            exit;
        }
    }

}