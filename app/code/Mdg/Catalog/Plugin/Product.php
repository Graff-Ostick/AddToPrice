<?php
declare(strict_types=1);

namespace Mdg\Catalog\Plugin;

use Magento\Catalog\Model\Product as ModelProduct;
use Mdg\Catalog\Model\AddToPriceData;

/**
 * Plugin to update ProductPlugin Price
 */
class Product
{
    /**
     * @var AddToPriceData
     */
    protected AddToPriceData $addToPriceData;

    /**
     * @param AddToPriceData $addToPriceData
     */
    public function __construct(
        AddToPriceData $addToPriceData
    ) {
        $this->addToPriceData = $addToPriceData;
    }

    /**
     * Get ProductPlugin price and add the value from config.xml
     * @param ModelProduct $subject
     * @param $result
     * @return mixed
     */
    public function afterGetPrice(ModelProduct $subject, $result)
    {
        if ($this->addToPriceData->getModuleEnabled()) {
            $result+= $this->addToPriceData->getTax();
        }
        return $result;
    }
}
