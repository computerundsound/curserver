<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.19 at 22:40 MEZ
 */

namespace app\installer;


/**
 * Class Xampp
 *
 * @package app\installer
 */
class Xampp
{
    /**
     * @var string
     */
    protected $xamppDir;


    /**
     * Xampp constructor.
     *
     * @param string $xamppDir
     */
    public function __construct(string $xamppDir)
    {

        $this->xamppDir = $xamppDir;
    }


}