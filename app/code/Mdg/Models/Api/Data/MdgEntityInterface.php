<?php
declare(strict_types=1);

namespace Mdg\Models\Api\Data;

interface MdgEntityInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const MDG_ENTITY_ID = 'mdg_entity_id';
    const NAME = 'name';
    const CREATED_AT = 'created_at';

    /**
     * Get mdg_entity_id
     * @return int
     */
    public function getMdgEntityId();

    /**
     * Set mdg_entity_id
     * @param int $mdgEntityId
     * @return MdgEntityInterface
     */
    public function setMdgEntityId(int $mdgEntityId):MdgEntityInterface;

    /**
     * Get Name
     * @return string
     */
    public function getName():string;

    /**
     * Set Name
     * @param string $name
     * @return MdgEntityInterface
     */
    public function setName(string $name):MdgEntityInterface;

    /**
     * Get CreatedAt
     * @return string
     */
    public function getCreatedAt():string;

    /**
     * Set CreatedAt
     * @param string $createdAt
     * @return MdgEntityInterface
     */
    public function setCreatedAt(string $createdAt):MdgEntityInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mdg\Models\Api\Data\MdgEntityExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Mdg\Models\Api\Data\MdgEntityExtensionInterface $extensionAttributes
     * @return mixed
     */
    public function setExtensionAttributes(\Mdg\Models\Api\Data\MdgEntityExtensionInterface $extensionAttributes);
}
