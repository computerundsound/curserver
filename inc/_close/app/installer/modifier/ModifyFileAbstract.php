<?php /** @noinspection RealpathInStreamContextInspection */

/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 22:58 MEZ
 */

namespace app\installer\modifier;


use app\installer\file\FileInfo;
use app\installer\file\PathWorker;
use RuntimeException;

/**
 * Class ModifiyFileAbstract
 *
 * @package app\installer\modifier
 */
class ModifyFileAbstract
{

    use PathWorker;

    /**
     * @var FileInfo
     */
    protected $fileInfo;

    protected $xamppDir;


    /**
     * ModifiyFileAbstract constructor.
     *
     * @param FileInfo $fileInfo
     * @param string   $xamppDir
     */
    public function __construct(FileInfo $fileInfo, string $xamppDir)
    {

        $this->fileInfo = $fileInfo;
        $this->xamppDir = $xamppDir;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function getContentFromFile(string $path): string
    {

        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException('No content found');
        }

        return $content;
    }

    /**
     * @param string $path
     * @param string $content
     */
    protected function writeContent(string $path, string $content): void
    {

        file_put_contents($path, $content);

    }

}