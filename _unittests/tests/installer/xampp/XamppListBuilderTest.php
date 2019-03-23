<?php
/**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.22 at 22:01 MEZ
 */

namespace _unittests\tests\installer\xampp;

use app\installer\xampp\XamppListBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class XamppListBuilderTest
 *
 * @package _unittests\tests\installer\xampp
 */
class XamppListBuilderTest extends TestCase
{

    protected $xamppListBuilder;

    /**
     *
     */
    public function testGetXamppList(): void
    {

        $path = __DIR__ . '/../../../../../';

        $xamppList = $this->xamppListBuilder->getXamppList($path);

    }

    protected function setUp()
    {

        $this->xamppListBuilder = new XamppListBuilder();

        parent::setUp();
    }


}
