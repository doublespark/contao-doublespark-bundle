<?php

namespace Doublespark\ContaoDoublesparkBundle\Tests\Unit\DependencyInjection;

use Doublespark\ContaoDoublesparkBundle\DependencyInjection\DoublesparkExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class DoublesparkExtensionTest extends TestCase {

    public function testInstantiates()
    {
        $extension = new DoublesparkExtension();
        $this->assertInstanceOf(DoublesparkExtension::class, $extension);
    }

    public function testLoadsServices()
    {
        $container = new ContainerBuilder(
            new ParameterBag([
                'kernel.debug' => false,
                'kernel.charset' => 'UTF-8',
                'kernel.project_dir' => '/dir',
                'kernel.default_locale' => 'en',
            ])
        );

        $extension = new DoublesparkExtension();
        $extension->load([],$container);

        $arrServices = $container->getServiceIds();

        $this->assertContains('Doublespark\ContaoDoublesparkBundle\BackendModules\MetaImportExport', $arrServices);
        $this->assertContains('Doublespark\ContaoDoublesparkBundle\ContaoManager\Plugin', $arrServices);
        $this->assertContains('Doublespark\ContaoDoublesparkBundle\DependencyInjection\DoublesparkExtension', $arrServices);
        $this->assertContains('Doublespark\ContaoDoublesparkBundle\DoublesparkBundle', $arrServices);
        $this->assertContains('Doublespark\ContaoDoublesparkBundle\Elements\BannerImageElementController', $arrServices);
        $this->assertContains('Doublespark\ContaoDoublesparkBundle\Elements\ContentGridEndElementController', $arrServices);
        $this->assertContains('Doublespark\ContaoDoublesparkBundle\Elements\ContentGridStartElementController', $arrServices);
    }
}