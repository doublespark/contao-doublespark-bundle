<?php

namespace Doublespark\ContaoDoublesparkBundle\Tests\Unit;

use Doublespark\ContaoDoublesparkBundle\DoublesparkBundle;
use PHPUnit\Framework\TestCase;

class DoublesparkBundleTest extends TestCase {

    public function testInstantiates()
    {
        $bundle = new DoublesparkBundle();
        $this->assertInstanceOf(DoublesparkBundle::class, $bundle);
    }

    public function testGetsPath()
    {
        $bundle = new DoublesparkBundle();
        $path = $bundle->getPath();
        $expectedPath = str_replace('\tests','',dirname(__DIR__));
        $this->assertEquals($expectedPath, $path);
    }
}