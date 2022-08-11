<?php
declare(strict_types=1);

namespace Mdg\Models\Model\Api\Data;

interface MdgEntityInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID = 'mdg_entity_id';
    const NAME = 'name';
    const CREATED_AT = 'created_at';

    /**
     * @return string
     */
    public function getMdgEntityId():string;

    /**
     * @param int $mdgEntityId
     * @return MdgEntityInterface
     */
    public function setMdgEntityId(int $mdgEntityId):MdgEntityInterface;

    /**
     * @return string
     */
    public function getName():string;

    /**
     * @param string $name
     * @return MdgEntityInterface
     */
    public function setName(string $name):MdgEntityInterface;

    /**
     * @return string
     */
    public function getCreatedAt():string;

    /**
     * @param string $createdAt
     * @return MdgEntityInterface
     */
    public function setCreatedAt(string $createdAt):MdgEntityInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mdg\Models\Model\Api\Data\MdgEntityExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Mdg\Models\Model\Api\Data\MdgEntityExtensionInterface $extensionAttributes
     * @return mixed
     */
    public function setExtensionAttributes(\Mdg\Models\Model\Api\Data\MdgEntityExtensionInterface $extensionAttributes);
}
