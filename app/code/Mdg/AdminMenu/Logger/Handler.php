<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Logger;

use Magento\Framework\Logger\Handler\Base;

class Handler extends Base
{
    /**
     * file path to custom logger
     * @var string
     */
    protected $fileName = '/var/log/custom_entity.log';
}
