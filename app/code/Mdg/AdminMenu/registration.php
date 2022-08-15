<?php
declare(strict_types=1);

namespace Mdg\AdminMenu;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    "Mdg_AdminMenu",
    __DIR__
);
