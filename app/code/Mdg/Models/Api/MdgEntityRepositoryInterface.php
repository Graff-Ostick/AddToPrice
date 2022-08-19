<?php
declare(strict_types=1);

namespace Mdg\Models\Api;

use Magento\Framework\Api\SearchResultsInterface;

interface MdgEntityRepositoryInterface
{
    /**
     * Save entity.
     *
     * @param \Mdg\Models\Api\Data\MdgEntityInterface $mdgEntity
     * @return \Mdg\Models\Api\Data\MdgEntityInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Mdg\Models\Api\Data\MdgEntityInterface $mdgEntity);

    /**
     * Retrieve entity.
     *
     * @param int $mdgEntityId
     * @return \Mdg\Models\Api\Data\MdgEntityInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($mdgEntityId);

    /**
     * Retrieve entity matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mdg\Models\Api\Data\MdgEntitySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete entity.
     *
     * @param \Mdg\Models\Api\Data\MdgEntityInterface $mdgEntity
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Mdg\Models\Api\Data\MdgEntityInterface $mdgEntity);

    /**
     * Delete entity by ID.
     *
     * @param int $mdgEntityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $mdgEntityId): bool;
}
