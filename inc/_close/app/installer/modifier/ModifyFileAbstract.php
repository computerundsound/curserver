<?php /** @noinspection RealpathInStreamContextInspection */

/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 22:58 MEZ
 */

namespace app\installer\modifier;


use app\installer\file\FileInfo;
use app\installer\xampp\Xampp;
use app\PathTrait;
use RuntimeException;

/**
 * Class ModifiyFileAbstract
 *
 * @package app\installer\modifier
 */
class ModifyFileAbstract
{

    use PathTrait;

    /**
     * @var FileInfo
     */
    protected $fileInfoFromFileToModify;
    /**
     * @var Xampp
     */
    protected $xampp;


    /**
     * ModifiyFileAbstract constructor.
     *
     * @param FileInfo $fileInfoFromFileToModify
     * @param Xampp    $xampp
     */
    public function __construct(FileInfo $fileInfoFromFileToModify, Xampp $xampp)
    {

        $this->fileInfoFromFileToModify = $fileInfoFromFileToModify;
        $this->xampp                    = $xampp;
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

    /**
     * @param string $content
     * @param array  $replacer
     *
     * @return string
     */
    protected function replaceContents(string $content, array $replacer): string
    {

        foreach ($replacer as $search => $newValue) {
            $content = $this->replaceLine($search, $newValue, $content);
        }

        return $content;
    }

    /**
     * @param string $search
     * @param string $newValue
     * @param string $content
     *
     * @return string
     */
    protected function replaceLine(string $search, string $newValue, string $content): string
    {

        $replace = "$search = $newValue";

        $content = preg_replace("/^[\\s]*$search.*/m", $replace, $content);

        return $content;

    }


}