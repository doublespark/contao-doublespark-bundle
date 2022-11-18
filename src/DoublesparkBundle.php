<?php

namespace Doublespark\Doublespark;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DoublesparkBundle
 *
 * @package Doublespark
 */
class DoublesparkBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
