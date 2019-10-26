<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.20 at 23:18 MEZ
 */

namespace app\installer\Replacer;


use app\ArrayTrait;

/**
 * Class ReplaceBuilder
 *
 * @package app\installer\Replacer
 */
class ReplaceBuilder
{

    use ArrayTrait;

    /**
     * @param string $pathToReplacerIni
     *
     * @return Replacer
     */
    public function getReplacer($pathToReplacerIni)
    {

        $parsedIni = parse_ini_file($pathToReplacerIni, true);

        $vhost    = self::getValueFromArray('vhost', $parsedIni, []);
        $phpIni   = self::getValueFromArray('phpIni', $parsedIni, []);
        $mysqlIni = self::getValueFromArray('mysqlIni', $parsedIni, []);
        $mariaDbIni = self::getValueFromArray('mariaDbIni', $parsedIni, []);
        $phpIniExtended = self::getValueFromArray('phpIniExtend', $parsedIni, []);

        $replacer = new Replacer($vhost, $phpIni, $phpIniExtended, $mysqlIni, $mariaDbIni);

        return $replacer;

    }

}