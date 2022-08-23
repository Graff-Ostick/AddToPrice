<?php
declare(strict_types=1);

namespace Mdg\CliSample;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Mdg_CliSample',
    __DIR__
);
