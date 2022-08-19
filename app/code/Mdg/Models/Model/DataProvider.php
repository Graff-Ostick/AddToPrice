<?php
declare(strict_types=1);

namespace Mdg\Models\Model;

use Mdg\Models\Api\Data\MdgEntityInterface;
use Mdg\Models\Api\MdgEntityRepositoryInterface;
use Mdg\Models\Model\ResourceModel\MdgEntity\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $CollectionFactory
     * @param MdgEntityRepositoryInterface|null $entityRepository
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param RequestInterface|null $request
     * @param MdgEntityFactory $mdgEntityFactory
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        MdgEntityRepositoryInterface $entityRepository = null,
        ?RequestInterface $request = null,
        MdgEntityFactory $mdgEntityFactory
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $CollectionFactory->create();
        $this->entityRepository = $entityRepository  ?? ObjectManager::getInstance()->get(MdgEntityRepositoryInterface::class);
        $this->dataPersistor = $dataPersistor;
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->mdgEntityFactory = $mdgEntityFactory;
    }

    /**
     * Get Data
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $entity = $this->getCurrentEntity();
        $this->loadedData[$entity->getMdgEntityId()] = $entity->getData();

        return $this->loadedData;
    }

    /**
     * @return MdgEntityInterface
     */
    private function getCurrentEntity(): MdgEntityInterface
    {
        $entityId = $this->getEntityId();

        if ($entityId) {
            try {
                $entity = $this->entityRepository->getById($entityId);
            } catch (LocalizedException $e) {
                $entity = $this->mdgEntityFactory->create();
            }
            return $entity;
        }

        $data = $this->dataPersistor->get('mdg_customentity');
        if (empty($data)) {
            return $this->mdgEntityFactory->create();
        }
        $this->dataPersistor->clear('mdg_customentity');

        return $this->mdgEntityFactory->create()->setData($data);
    }

    /**
     * return mdg entity id from reguest
     * @return int
     */
    private function getEntityId()
    {
        return (int) $this->request->getParam('mdg_entity_id');
    }
}
