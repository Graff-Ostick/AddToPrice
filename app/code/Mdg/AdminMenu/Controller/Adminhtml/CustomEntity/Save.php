<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

class Save extends CustomEntity
{
    /**
     * Save new entity
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $mdgEntityModel = $this->_mdgEntityFactory->create();
            $mdgEntityId = $this->getRequest()->getParam("mdg_entity_id");

            if ($mdgEntityId) {
                $mdgEntityModel->load($mdgEntityId);
            }
            $formData = $this->getRequest()->getParam('post');
            $mdgEntityModel->setData($formData);

            try {
                $mdgEntityModel->save();
                $this->messageManager->addSuccess(__('The entity has been saved'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect(
                        '*/*/edit',
                        ['mdg_entity_id' => $mdgEntityModel->getMdgEntityId(),
                        '_current' => true ]
                    );
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_logger->addError('Error while save the entity ' . $e);
            }

            $this->_getSession()->setFormData($formData);
            $this->_redirect('*/*/edit', ['mdg_entity_id' => $mdgEntityId]);
        }
    }
}
