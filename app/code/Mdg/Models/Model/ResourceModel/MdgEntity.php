<?php
declare(strict_types=1);

namespace Mdg\Models\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MdgEntity extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mdg_entity', 'entity_id');
    }
}
