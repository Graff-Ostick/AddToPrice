<?php
declare(strict_types=1);

namespace Mdg\Catalog\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mdg\Catalog\Model\ChangeName\ChangeName;

/**
 * Change product name after save
 */
class ProductCreated implements ObserverInterface
{
    /**
     * @var ChangeName
     */
    private ChangeName $changeName;

    /**
     * @param ChangeName $changeName
     */
    public function __construct(
        ChangeName $changeName
    ) {
        $this->changeName = $changeName;
    }

    public function execute(Observer $observer)
    {
        if (!$observer->getProduct()->getId()) {
            $oldName = $observer->getProduct()->getName();
            $newName = $this->changeName->changeName($oldName, " NEW");
            $observer->getProduct()->setName($newName);
        }
    }
}
