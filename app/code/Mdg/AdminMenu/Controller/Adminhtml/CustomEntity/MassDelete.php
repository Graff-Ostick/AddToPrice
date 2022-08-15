<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;
use Mdg\Models\Model\MdgEntityFactory;
use Mdg\Models\Model\ResourceModel\MdgEntityFactory as resMdgEntityFactory;
use Mdg\AdminMenu\Logger\Logger;

/**
 * @property Logger $_logger
 * @property resMdgEntityFactory $_resMdgEntityFactory
 */
class MassDelete extends CustomEntity
{
    /**
     * @var resMdgEntityFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param MdgEntityFactory $mdgEntityFactory
     * @param resMdgEntityFactory $resMdgEntityFactory
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        MdgEntityFactory $mdgEntityFactory,
        resMdgEntityFactory $resMdgEntityFactory,
        Logger $logger
    ) {
        parent::__construct($context, $coreRegistry, $resultPageFactory, $mdgEntityFactory, $logger);
        $this->_resMdgEntityFactory = $resMdgEntityFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $mdgEntityIds = $this->getRequest()->getParams()['mdg_entity_id'];
        $model = $this->_mdgEntityFactory->create();
        $resModel = $this->_resMdgEntityFactory->create();
        if (count($mdgEntityIds)) {
            $i = 0;
            foreach ($mdgEntityIds as $mdgEntityId) {
                try {
                    $resModel->load($model, $mdgEntityId, 'mdg_entity_id');
                    $resModel->delete($model);
                    $i++;
                } catch (\Exception $e) {
                    $this->_logger->addError("Something went wrong with model,
                     when try to load or delete - " . $e);
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
            if ($i > 0) {
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 item(s) were deleted.', $i)
                );
            }
        } else {
            $this->messageManager->addErrorMessage(
                __('You can not delete item(s), Please check again %1')
            );
        }
        $this->_redirect('*/*/index');
    }
}
