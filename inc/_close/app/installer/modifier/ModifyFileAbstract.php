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
     * @var string
     */
    private $xamppContainerDir;


    /**
     * ModifiyFileAbstract constructor.
     *
     * @param FileInfo $fileInfo
     * @param string   $xamppDir
     */
    public function __construct(FileInfo $fileInfo, string $xamppDir)
    {

        $this->fileInfo          = $fileInfo;
        $this->xamppDir          = $xamppDir;
        $this->xamppContainerDir = realpath($xamppDir . '/../');
    }

    /**
     * @return string
     */
    protected function getContentFromFile(): string
    {

        $content = file_get_contents($this->fileInfo->getFullPath());

        if ($content === false) {
            throw new RuntimeException('No content found');
        }

        return $content;
    }

    /**
     * @param string $content
     */
    protected function writeContent(string $content): void
    {

        file_put_contents($this->fileInfo->getFullPath(), $content);

    }

}