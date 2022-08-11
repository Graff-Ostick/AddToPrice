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
     * @return int
     */
    public function getMdgEntityId():int;

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
}
