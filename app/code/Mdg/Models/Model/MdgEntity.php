<?php
declare(strict_types=1);

namespace Mdg\Models\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Mdg\Models\Model\Api\Data\MdgEntityInterface;

class MdgEntity extends AbstractModel implements IdentityInterface, MdgEntityInterface
{
    const CACHE_TAG = "mdg_entity";

    protected function _construct()
    {
        $this->_init('Mdg\Models\Model\ResourceModel\MdgEntity');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int
     */
    public function getMdgEntityId():int
    {
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
}
