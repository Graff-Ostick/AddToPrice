<?php
declare(strict_types=1);

namespace Mdg\Cron;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Mdg_Cron',
    __DIR__
);
