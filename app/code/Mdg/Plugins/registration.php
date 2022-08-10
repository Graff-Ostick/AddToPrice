<?php
declare(strict_types=1);

namespace Mdg\Plugins;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Mdg_Plugins',
    __DIR__
);
