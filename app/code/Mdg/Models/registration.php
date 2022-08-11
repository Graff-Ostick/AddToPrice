<?php
declare(strict_types=1);

namespace Mdg\Models;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Mdg_Models',
    __DIR__
);
