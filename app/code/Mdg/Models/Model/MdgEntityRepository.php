<?php
declare(strict_types=1);

namespace Mdg\Models\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Mdg\Models\Api\MdgEntityRepositoryInterface;
use Mdg\Models\Api\Data\MdgEntityInterface;
use Mdg\Models\Api\Data\MdgEntitySearchResultsInterface;
use Mdg\Models\Api\Data\MdgEntitySearchResultsInterfaceFactory;
use Mdg\Models\Model\ResourceModel\MdgEntity\Collection;
use Mdg\Models\Model\ResourceModel\MdgEntity as ResourceMdgEntity;
use Mdg\Models\Model\ResourceModel\MdgEntity\CollectionFactory as MdgEntityCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\EntityManager\HydratorInterface;

class MdgEntityRepository implements MdgEntityRepositoryInterface
{
    /**
     * @var MdgEntityFactory
     */
    private $mdgEntityFactory;

    /**
     * @var MdgEntityCollectionFactory
     */
    private $mdgEntityCollectionFactory;

    /**
     * @var MdgEntitySearchResultsInterfaceFactory
     */
    private $searchResultInterfaceFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessorInterface;

    /**
     * @var ResourceMdgEntity
     */
    private ResourceMdgEntity $resourceMdgEntity;


    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param MdgEntityFactory $mdgEntityFactory
     * @param ResourceMdgEntity $resourceMdgEntity
     * @param MdgEntityCollectionFactory $mdgEntityCollectionFactory
     * @param MdgEntitySearchResultsInterfaceFactory $mdgEntitySearchResultsInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @return void
     */
    public function __construct(
        MdgEntityFactory                       $mdgEntityFactory,
        ResourceMdgEntity                      $resourceMdgEntity,
        MdgEntityCollectionFactory             $mdgEntityCollectionFactory,
        MdgEntitySearchResultsInterfaceFactory $mdgEntitySearchResultsInterfaceFactory,
        CollectionProcessorInterface           $collectionProcessor
    ) {
        $this->mdgEntityFactory = $mdgEntityFactory;
        $this->resourceMdgEntity = $resourceMdgEntity;
        $this->mdgEntityCollectionFactory = $mdgEntityCollectionFactory;
        $this->mdgEntitySearchResultInterfaceFactory = $mdgEntitySearchResultsInterfaceFactory;
        $this->collectionProcessorInterface = $collectionProcessor;
    }

    /**
     * Save entity
     * @param MdgEntityInterface|MdgEntity $mdgEntity
     * @return MdgEntity
     * @throws CouldNotSaveException
     */
    public function save(MdgEntityInterface $mdgEntity)
    {
        try {
            $this->resourceMdgEntity->save($mdgEntity);
        } catch (\LocalizedException $e) {
            throw new CouldNotSaveException(
                __('Could not save the entity: %1', $e->getMessage()),
                $e
            );
        } catch (\Throwable $e) {
            throw new CouldNotSaveException(
                __('Could not save the entity: %1', __('Something went wrong while saving the entity.')),
                $e
            );
        }
        return $mdgEntity;
    }

    /**
     * Get entity by id
     * @param $mdgEntityId
     * @return MdgEntityInterface|MdgEntity
     * @throws NoSuchEntityException
     */
    public function getById($mdgEntityId)
    {
        $mdgEntity = $this->mdgEntityFactory->create();
        $mdgEntity->load($mdgEntityId);

        if (!$mdgEntity->getMdgEntityId()) {
            throw new NoSuchEntityException(__('The entity with the "%1" ID doesn\'t exist.', $mdgEntityId));
        }

        return $mdgEntity;
    }

    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->mdgEntityCollectionFactory->create();

        $this->collectionProcessorInterface->process($criteria, $collection);

        $searchResults = $this->mdgEntitySearchResultInterfaceFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete entity
     *
     * @param MdgEntityInterface $mdgEntity
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(MdgEntityInterface $mdgEntity)
    {
        try {
            $this->resourceMdgEntity->delete($mdgEntity);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entity: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete entity by given Id
     *
     * @param int $mdgEntityId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($mdgEntityId): bool
    {
        return $this->delete($this->getById($mdgEntityId));
    }
}
