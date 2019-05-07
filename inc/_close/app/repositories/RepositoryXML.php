<?php /** @noinspection PhpComposerExtensionStubsInspection */

/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.05.07 at 02:01 MESZ
 */

namespace app\repositories;


use SimpleXMLElement;

/**
 * Class Repository
 *
 * @package app\repositories
 */
class RepositoryXML
{
    /**
     * @var SimpleXMLElement
     */
    protected $XMLElement;
    /**
     * @var string
     */
    protected $filePathToXML;


    /**
     * Repository constructor.
     *
     * @param string $filePathToXML
     */
    public function __construct($filePathToXML)
    {

        $this->filePathToXML = $filePathToXML;
        $content = file_get_contents($this->filePathToXML);
        $this->XMLElement = simplexml_load_string($content);
    }
}