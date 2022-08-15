<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

class Grid extends CustomEntity
{
    /**
     * @return ResponseInterface|ResultInterface|Page|void
     */
    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}
