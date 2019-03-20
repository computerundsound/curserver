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
     * @param string $pathToEnvironmentFile
     *
     * @return Replacer
     */
    public function getReplacer(string $pathToEnvironmentFile): Replacer
    {

        $parsedIni = parse_ini_file($pathToEnvironmentFile, true);

        $vhost    = self::getValueFromArray('vhost', $parsedIni, []);
        $phpIni   = self::getValueFromArray('phpIni', $parsedIni, []);
        $mysqlIni = self::getValueFromArray('mysqlIni', $parsedIni, []);

        $replacer = new Replacer($vhost, $phpIni, $mysqlIni);

        return $replacer;

    }

}