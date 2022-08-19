<?php
declare(strict_types=1);

namespace Mdg\Models\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Model\AbstractModel;
use Mdg\Models\Api\Data\MdgEntityInterface;
use Mdg\Models\Model\ResourceModel\MdgEntity as ResourceModel;

class MdgEntity extends AbstractModel implements MdgEntityInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = "mdg_entity";

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Get mdg_entity_id
     * @return int
     */
    public function getMdgEntityId()
    {
        return $this->getData(self::MDG_ENTITY_ID);
    }

    /**
     * Set mdg_entity_id
     * @param int $mdgEntityId
     * @return MdgEntityInterface
     */
    public function setMdgEntityId(int $mdgEntityId):MdgEntityInterface
    {
        return $this->setData(self::MDG_ENTITY_ID, $mdgEntityId);
    }

    /**
     * Get Name
     * @return string
     */
    public function getName():string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name
     * @param string $name
     * @return MdgEntityInterface
     */
    public function setName(string $name):MdgEntityInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get Created_At
     * @return string
     */
    public function getCreatedAt():string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Created_At
     * @param string $createdAt
     * @return MdgEntityInterface
     */
    public function setCreatedAt(string $createdAt):MdgEntityInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get Extension Attributes
     * @return \Mdg\Models\Api\Data\MdgEntityExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set Extension Attributes
     * @param \Mdg\Models\Api\Data\MdgEntityExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Mdg\Models\Api\Data\MdgEntityExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
