<?php
declare(strict_types=1);

namespace App\Service\XmlRepository;

use SimpleXMLElement;

/**
 * Class Repository
 *
 * @package app\repositories
 */
class RepositoryXML
{

    protected SimpleXMLElement $simpleXMLElement;
    /**
     * @var string
     */
    protected string $filePathToXML;


    public function __construct(string $filePathToXML)
    {

        $this->filePathToXML = $filePathToXML;
        $this->createIfNotExists($filePathToXML);
        $content                = file_get_contents($this->filePathToXML);
        $this->simpleXMLElement = simplexml_load_string($content);
    }

    private function createIfNotExists(string $filePathToXml): void
    {

        if (false === file_exists($filePathToXml)) {
            file_put_contents($filePathToXml, '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '</xml>');
        }
    }
}