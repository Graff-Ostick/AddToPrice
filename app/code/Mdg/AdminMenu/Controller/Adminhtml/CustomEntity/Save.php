<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Mdg\AdminMenu\Logger\Logger;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Mdg\Models\Model\MdgEntityFactory;
use Mdg\Models\Model\ResourceModel\MdgEntity as Resource;
use Mdg\Models\Model\ResourceModel\MdgEntity\Collection;
use Mdg\Models\Api\MdgEntityRepositoryInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var MdgEntityFactory
     */
    private $mdgEntityFactory;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Context $context
     * @param MdgEntityFactory $mdgEntityFactory
     * @param Resource $resource
     * @param MdgEntityRepositoryInterface $mdgEntityRepository
     * @param Collection $collection
     * @param Logger $logger
     */
    public function __construct(
        Context                      $context,
        MdgEntityFactory             $mdgEntityFactory,
        Resource                     $resource,
        MdgEntityRepositoryInterface $mdgEntityRepository,
        Collection                   $collection,
        Logger                       $logger
    ) {
        parent::__construct($context);
        $this->mdgEntityFactory = $mdgEntityFactory;
        $this->resource = $resource;
        $this->mdgEntityRepository = $mdgEntityRepository;
        $this->collection = $collection;
        $this->logger = $logger;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        if (empty($data['mdg_entity_id'])) {
            $data['mdg_entity_id'] = (int) $this->collection->getLastItem()->getData('mdg_entity_id') + 1;
        }
        try {
            $model = $this->mdgEntityFactory->create();

            unset($data['form_key']);

            $id = $this->getRequest()->getParam('mdg_entity_id');
            if ($id) {
                try {
                    $model = $this->mdgEntityRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This entity no longer exists.'));
                    $this->logger->addError(__('This entity no longer exists. ' . $e));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->mdgEntityRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the entity.'));

            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the entity. Controller'
                    . $e->getMessage()));
            }

        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
            $this->logger->addError(__('Entity doesnt save - ' . $e));
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mdg_AdminMenu::save');
    }
}
