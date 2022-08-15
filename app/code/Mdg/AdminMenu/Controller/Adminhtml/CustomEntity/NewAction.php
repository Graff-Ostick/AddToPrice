<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

class NewAction extends CustomEntity
{
    /**
     * Forward as to edit page for create new entity
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
