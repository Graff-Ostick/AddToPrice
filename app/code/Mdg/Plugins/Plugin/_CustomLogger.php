<?php
declare(strict_types=1);

namespace Mdg\Plugins\Plugin;

use Magento\Catalog\Controller\Adminhtml\Product\Save;

class CustomLogger
{
    public function aroundExecute(Save $subject, callable $proceed)
    {
        $result = $proceed;
        return $result;
    }
}
