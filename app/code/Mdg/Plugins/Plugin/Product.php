<?php
declare(strict_types=1);

namespace Mdg\Plugins\Plugin;

use Magento\Catalog\Model\Product as ModelProduct;
use Mdg\Plugins\Logger\Logger as Logger;

class Product
{
    /**
     * Logging instance
     * @var Logger
     */
    protected $_logger;

    /**
     * Constructor
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger
    ) {
        $this->_logger = $logger;
    }

    /**
     * Add "CUSTOMIZED" to product name after setName
     * @param ModelProduct $product
     * @param $result
     * @return string
     */
    public function beforeSetName(ModelProduct $product, $result)
    {
        return $result . ' CUSTOMIZED';
    }

    /**
     * Doubles the price of the product
     * @param ModelProduct $product
     * @param $result
     * @return float|int
     */
    public function afterGetPrice(ModelProduct $product, $result)
    {
        return 2*$result;
    }

    /**
     * Call log when product created
     * @param ModelProduct $product
     * @param callable $proceed
     * @return callable
     */
    public function aroundBeforeSave(ModelProduct $product, callable $proceed)
    {
        if (!$product->getCreatedAt()) {
            $this->_logger->notice($product->getSku() . " is NEW");
        }

        if ($product->getData('price')<100) {
            $this->_logger->notice($product->getSku() . " price lower then 100!");
        }
        return $proceed();
    }
}
