<?php
declare(strict_types=1);

namespace Mdg\Models\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Mdg\Models\Model\Api\Data\MdgEntityInterface;
use Mdg\Models\Model\ResourceModel\MdgEntity as ResourceModel;

class MdgEntity extends AbstractModel implements IdentityInterface, MdgEntityInterface
{
    const CACHE_TAG = "mdg_entity";

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getMdgEntityId():string
    {
        try {
             $this->getData(self::ENTITY_ID);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return 'Mdg entity Id not found ' . $e;
        }
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $mdgEntityId
     * @return MdgEntityInterface
     */
    public function setMdgEntityId(int $mdgEntityId):MdgEntityInterface
    {
        return $this->setData(self::ENTITY_ID, $mdgEntityId);
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return MdgEntityInterface
     */
    public function setName(string $name):MdgEntityInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getCreatedAt():string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return MdgEntityInterface
     */
    public function setCreatedAt(string $createdAt):MdgEntityInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @return \Mdg\Models\Model\Api\Data\MdgEntityExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param \Mdg\Models\Model\Api\Data\MdgEntityExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Mdg\Models\Model\Api\Data\MdgEntityExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
