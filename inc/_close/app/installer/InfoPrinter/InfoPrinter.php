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

    protected const INFO_PREFIX    = '[INFO] ';
    protected const WARNING_PREFIX = '[WARNING] ';
    protected const ERROR_PREFIX   = '[ERROR] ';

    protected const NEW_LINE = "\n";

    /**
     * @param string $message
     * @param array  $dataToAppend
     */
    public static function info(string $message, array $dataToAppend = []): void
    {

        self::echo(self::INFO_PREFIX, $message, $dataToAppend);

    }

    /**
     * @param string $message
     * @param array  $dataToAppend
     */
    public static function warning(string $message, array $dataToAppend = []): void
    {

        self::echo(self::WARNING_PREFIX, $message, $dataToAppend);

    }

    /**
     * @param string $message
     * @param array  $dataToAppend
     */
    public static function error(string $message, array $dataToAppend = []): void
    {

        self::echo(self::ERROR_PREFIX, $message, $dataToAppend);

    }

    /**
     * @param string $prefix
     * @param string $message
     * @param array  $dataToAppend
     */
    protected static function echo(string $prefix, string $message, array $dataToAppend): void
    {

        $dataToAppendAsString = self::buildDataToAppendString($dataToAppend);

        echo $prefix . $message . $dataToAppendAsString . self::NEW_LINE;
    }

    /**
     * @param array $dataToAppend
     *
     * @return string
     */
    protected static function buildDataToAppendString(array $dataToAppend): string
    {

        $dataToAppendString = '';

        if (count($dataToAppend) > 0) {
            $dataToAppendString = ' (' . print_r($dataToAppend, true) . ')';
        }

        return $dataToAppendString;

    }

}