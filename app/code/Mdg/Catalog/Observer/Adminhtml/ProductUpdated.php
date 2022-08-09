<?php
declare(strict_types=1);

namespace Mdg\Catalog\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mdg\Catalog\Model\ChangeName\ChangeName;

/**
 * Change product name after edit product
 */
class ProductUpdated implements ObserverInterface
{
    private ChangeName $changeName;

    public function __construct(
        ChangeName $changeName
    ) {
        $this->changeName = $changeName;
    }

    public function execute(Observer $observer)
    {
        $oldName = $observer->getProduct()->getName();
        $newName = $this->changeName->changeName($oldName, " EDITED");
        $newName = str_replace("NEW", '', $newName);
        $observer->getProduct()->setName($newName);
    }
}
