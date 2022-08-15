<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class CustomEntity extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_customentity';
        $this->_blockGroup = 'Mdg_AdminMenu';
        $this->_headerText = __('Manage Custom Entity');
        $this->_addButtonLabel = __('Add New Entity');
        parent::_construct();
    }
}
