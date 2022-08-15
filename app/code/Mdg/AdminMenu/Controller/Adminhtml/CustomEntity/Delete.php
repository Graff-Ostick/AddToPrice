<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Framework\View\Result\Page;
use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

class Delete extends CustomEntity
{
    /**
     * Delete entity | write error message
     * @return void
     */
    public function execute()
    {
        $mdgEntityId = (int) $this->getRequest()->getParam('mdg_entity_id');

        if ($mdgEntityId) {
            $mdgEntityModel = $this->_mdgEntityFactory->create();
            $mdgEntityModel->load($mdgEntityId);

            if (!$mdgEntityModel->getMdgEntityId()) {
                $this->messageManager->addError(__('This entity no longer exists.'));
                $this->_logger->addNotice("Somethings went wrong when try get id by mdg_entity table");
            } else {
                try {
                    $mdgEntityModel->delete();
                    $this->messageManager->addSuccess(__(' The entity has been deleted.'));
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_logger->addError('Cannot delete entity' . $e);
                    $this->_redirect('*/*/edit', ['mdg_entity_id' => $mdgEntityModel->getMdgEntityId()]);
                }
            }
        }
    }
}
