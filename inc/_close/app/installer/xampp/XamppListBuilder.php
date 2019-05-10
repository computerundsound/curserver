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
use app\vhost\VHostFiles;
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
     * @param VHostFiles $VHostFile
     * @param string     $xamppVersion
     * @param Replacer   $replacer
     *
     * @return string
     */
    protected static function getCorrespondingVHostFile(VHostFiles $VHostFile, $xamppVersion, Replacer $replacer)
    {

        $vhostFileName = $VHostFile->getVHostFileName($xamppVersion);

        $vhostFileName = isset($vhostFileName) ? $vhostFileName : '';

        return $vhostFileName;
    }

    /**
     * @param string     $xamppContainerPath
     * @param Replacer   $replacer
     * @param VHostFiles $vHostFile
     *
     * @return XamppList
     */
    public function getXamppList($xamppContainerPath, Replacer $replacer, VHostFiles $vHostFile)
    {

        $dirs = $this->getDirs($xamppContainerPath);

        $xamppList = $this->getList($dirs, $replacer, $vHostFile);

        return $xamppList;

    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function getDirs($path)
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
     * @param array      $dirs
     * @param Replacer   $replacer
     * @param VHostFiles $VHostFile
     *
     * @return XamppList
     */
    protected function getList(array $dirs, Replacer $replacer, VHostFiles $VHostFile)
    {

        $xamppList = new XamppList();

        foreach ($dirs as $dir) {

            if ($dir) {
                $xampp = $this->getXampp($dir, $replacer, $VHostFile);
                $xamppList->add($xampp);
            }

        }

        return $xamppList;

    }

    /**
     * @param string     $xamppDir
     * @param Replacer   $replacer
     * @param VHostFiles $vHostFile
     *
     * @return Xampp
     */
    protected function getXampp($xamppDir, Replacer $replacer, VHostFiles $vHostFile)
    {

        $version = Xampp::buildXamppVersion($xamppDir);

        $correspondingVHostFilePath = self::getCorrespondingVHostFile($vHostFile, $version, $replacer);

        return new Xampp($xamppDir, $correspondingVHostFilePath);

    }


}