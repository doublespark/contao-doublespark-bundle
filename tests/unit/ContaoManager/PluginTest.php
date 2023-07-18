<?php

namespace Doublespark\ContaoDoublesparkBundle\Tests\Unit\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Doublespark\ContaoDoublesparkBundle\ContaoManager\Plugin;
use PHPUnit\Framework\TestCase;

class PluginTest extends TestCase {

    public function testInstantiates()
    {
        $plugin = new Plugin();
        $this->assertInstanceOf(Plugin::class, $plugin);
    }

    public function testGetsBundles()
    {
        $mockParser = $this->createMock(ParserInterface::class);
        $plugin = new Plugin();
        $arrBundleConfig = $plugin->getBundles($mockParser);

        $bundle = $arrBundleConfig[0];

        $this->assertInstanceOf(BundleConfig::class,$bundle);
        $this->assertEquals('Doublespark\ContaoDoublesparkBundle\DoublesparkBundle',$bundle->getName());
    }
}