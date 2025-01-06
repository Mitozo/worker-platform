<?php

namespace App;

use App\Factory\EnumTypeFactory;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    // protected function initializeContainer(): void
    // {
    //     parent::initializeContainer();

    //     $container = $this->getContainer();
        
    //     // Register EnumTypes before Doctrine tries to use them
    //     if ($container->has(EnumTypeFactory::class)) {
    //         $enumFactory = $container->get(EnumTypeFactory::class);
    //         $enumFactory->registerEnumTypes();  // Ensure enum types are registered
    //     }
    // }
}
