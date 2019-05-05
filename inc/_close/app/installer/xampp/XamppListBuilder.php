<?php /** @noinspection StaticClosureCanBeUsedInspection */

/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 18:56 MEZ
 */

namespace app\installer\xampp;


use app\ArrayTrait;
use app\installer\Replacer\Replacer;
use app\xampp\ReplacerEnvironmentKeys;

/**
 * Class XamppListBuilder
 *
 * @package app\installer\xampp
 */
class XamppListBuilder
{

    use ArrayTrait;

    /**
     * @param string   $xamppVersion
     * @param Replacer $replacer
     *
     * @return string
     */
    protected static function getCorrespondingVHostFile(string $xamppVersion, Replacer $replacer): string
    {

        $vhostFileName = '';

        if (version_compare(5.4, $xamppVersion, '<=')) {
            $replacerKey = ReplacerEnvironmentKeys::VHOST_FILE_IF_VERSION_IS_GREATER_OR_EQUAL_THAN_5_4;
        }

        if (version_compare(5.4, $xamppVersion, '>=')) {
            $replacerKey = ReplacerEnvironmentKeys::VHOST_FILE_IF_VERSION_IS_SMALLER_THAN_5_4;
        }

        if (version_compare(5, $xamppVersion, '>')) {
            $replacerKey = ReplacerEnvironmentKeys::VHOST_FILE_IF_VERSION_IS_SMALLER_THAN_5;
        }

        if (isset($replacerKey)) {
            $vhostFileName = (string)self::getValueFromArray($replacerKey, $replacer->getVhostReplacer());
        }

        $vhostFileName = $vhostFileName ?? '';

        return $vhostFileName;
    }

    /**
     * @param string   $xamppContainerPath
     * @param Replacer $replacer
     *
     * @return XamppList
     */
    public function getXamppList(string $xamppContainerPath, Replacer $replacer): XamppList
    {

        $dirs = $this->getDirs($xamppContainerPath);

        $xamppList = $this->getList($dirs, $replacer);

        return $xamppList;

    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function getDirs($path): array
    {

        $dirs = glob($path . '/*', GLOB_ONLYDIR);

        $dirNames = array_map(function ($dir) {

            $dirFiltered = '';

            $dirName = basename($dir);

            if (strpos($dirName, 'xampp-') === 0) {
                $dirFiltered = realpath($dir);
            }

            return $dirFiltered;

        },
            $dirs);

        return array_filter($dirNames,
            function ($dir) {

                return (bool)$dir;
            });


    }

    /**
     * @param array    $dirs
     *
     * @param Replacer $replacer
     *
     * @return XamppList
     */
    protected function getList(array $dirs, Replacer $replacer): XamppList
    {

        $xamppList = new XamppList();

        foreach ($dirs as $dir) {

            if ($dir) {
                $xampp = $this->getXampp($dir, $replacer);
                $xamppList->add($xampp);
            }

        }

        return $xamppList;

    }

    /**
     * @param string   $xamppDir
     * @param Replacer $replacer
     *
     * @return Xampp
     */
    protected function getXampp(string $xamppDir, Replacer $replacer): Xampp
    {

        $version = Xampp::buildXamppVersion($xamppDir);

        $correspondingVHostFilePath = self::getCorrespondingVHostFile($version, $replacer);

        return new Xampp($xamppDir, $correspondingVHostFilePath);

    }


}