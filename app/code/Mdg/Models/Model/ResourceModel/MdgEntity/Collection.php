<?php
declare(strict_types=1);

namespace Mdg\Models\Model\ResourceModel\MdgEntity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mdg\Models\Model\MdgEntity as Model;
use Mdg\Models\Model\ResourceModel\MdgEntity as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'mdg_entity_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'mdg_entity_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'mdg_entity_collection';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
