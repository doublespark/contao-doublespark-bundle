<?php

/***
 * Doublespark bundle
 */
namespace Doublespark;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DoublesparkBundle
 *
 * @package Doublespark
 */
class DoublesparkBundle extends Bundle
{
    public function getParent()
    {
        return 'ContaoCoreBundle';
    }
}
