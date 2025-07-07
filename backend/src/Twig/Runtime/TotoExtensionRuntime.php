<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class TotoExtensionRuntime implements RuntimeExtensionInterface
{

    public function doSomething($value)
    {
        return 'MMM';
    }
}
