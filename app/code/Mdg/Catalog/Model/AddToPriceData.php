<?php
declare(strict_types=1);

namespace Mdg\Catalog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Model for take value from config.xml
 */
class AddToPriceData
{
    /**
     * Path to config from admin panel
     */
    const XML_PATH_CONFIG = 'mdg';

    protected ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return data from config.xml
     * @param $group
     * @param $field
     * @return mixed
     */
    private function getConfig($group, $field)
    {
        $storeScope = ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue(self::XML_PATH_CONFIG.'/'.$group.'/'.$field, $storeScope);
    }

    /**
     * Return value enable/disable module
     * @return mixed
     */
    public function getModuleEnabled()
    {
        return $this->getConfig('general', 'module_enable');
    }

    /**
     * Return tax value
     * @return mixed
     */
    public function getTax()
    {
        return $this->getConfig('product', 'tax');
    }
}
