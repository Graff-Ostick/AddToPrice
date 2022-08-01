<?php
declare(strict_types=1);

namespace Mdg\Catalog\Plugin;

use \Magento\Catalog\Model\Product as ModelProduct;
use Mdg\Catalog\Model\AddToPriceData;

/**
 * Plugin to update Product Price
 */
class Product
{

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
     * Get Product price and add the value from config.xml
     * @param ModelProduct $subject
     * @param $result
     */
    public function afterGetPrice(ModelProduct $subject, $result)
    {
        if ($this->addToPriceData->getModuleEnabled()) {
            $result+= $this->addToPriceData->getTax();
        }
        return $result;
    }
}
