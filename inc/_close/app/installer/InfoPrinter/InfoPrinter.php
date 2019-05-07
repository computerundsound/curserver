<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.04.07 at 00:28 MESZ
 */

namespace app\installer\InfoPrinter;


/**
 * Class InfoPrinter
 *
 * @package app\installer\InfoPrinter
 */
class InfoPrinter
{

    const INFO_PREFIX    = '[INFO] ';
    const WARNING_PREFIX = '[WARNING] ';
    const ERROR_PREFIX   = '[ERROR] ';

    const NEW_LINE = "\n";

    /**
     * @param string $message
     * @param array  $dataToAppend
     */
    public static function info($message, array $dataToAppend = [])
    {

        self::echoIt(self::INFO_PREFIX, $message, $dataToAppend);

    }

    /**
     * @param string $message
     * @param array  $dataToAppend
     */
    public static function warning($message, array $dataToAppend = [])
    {

        self::echoIt(self::WARNING_PREFIX, $message, $dataToAppend);

    }

    /**
     * @param string $message
     * @param array  $dataToAppend
     */
    public static function error($message, array $dataToAppend = [])
    {

        self::echoIt(self::ERROR_PREFIX, $message, $dataToAppend);

    }

    /**
     * @param string $prefix
     * @param string $message
     * @param array  $dataToAppend
     */
    protected static function echoIt($prefix, $message, array $dataToAppend)
    {

        $dataToAppendAsString = self::buildDataToAppendString($dataToAppend);

        echo $prefix . $message . $dataToAppendAsString . self::NEW_LINE;
    }

    /**
     * @param array $dataToAppend
     *
     * @return string
     */
    protected static function buildDataToAppendString(array $dataToAppend)
    {

        $dataToAppendString = '';

        if (count($dataToAppend) > 0) {
            $dataToAppendString = ' (' . print_r($dataToAppend, true) . ')';
        }

        return $dataToAppendString;

    }

}