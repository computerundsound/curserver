<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 18:56 MEZ
 */

namespace app\installer\xampp;


/**
 * Class XamppList
 *
 * @package app\installer\xampp
 */
class XamppList
{

    protected $xampps = [];

    /**
     * @param Xampp $xampp
     */
    public function add(Xampp $xampp): void
    {

        $this->xampps[] = $xampp;

    }

    /**
     * @return Xampp[]
     */
    public function getXampps(): array
    {

        return $this->xampps;
    }

}