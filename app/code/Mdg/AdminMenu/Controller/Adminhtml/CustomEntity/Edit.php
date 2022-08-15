<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Framework\View\Result\Page;
use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

class Edit extends CustomEntity
{
    /**
     * @return Page|void
     */
    public function execute()
    {
        $mdgEntityId = $this->getRequest()->getParam('id');
        $model = $this->_mdgEntityFactory->create();

        if ($mdgEntityId) {
            $model->load($mdgEntityId);
            if (!$model->getMdgEntityId()) {
                $this->messageManager->addError(__('This entity no longer exists'));
                $this->_logger->addNotice('MdgEntityId doesnt find');
                $this->_redirect('*/*/');
                return;
            }
        }
        $data = $this->_session->getNewData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->registry('mdg_entity', $model);
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Mdg_adminMenu::label');
        $resultPage->getConfig()->getTitle()->prepend(__('Entity'));

        return $resultPage;
    }
}
