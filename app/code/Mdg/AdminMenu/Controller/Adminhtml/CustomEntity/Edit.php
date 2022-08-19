<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Mdg\Models\Model\MdgEntityFactory;
use Mdg\Models\Model\ResourceModel\MdgEntity as ResourceModel;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param MdgEntityFactory $mdgEntityFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        Action\Context              $context,
        RedirectFactory             $redirectFactory,
        PageFactory                 $resultPageFactory,
        Registry                    $registry,
        MdgEntityFactory            $mdgEntityFactory,
        ResourceModel               $resourceModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->redirectFactory = $redirectFactory;
        $this->_coreRegistry = $registry;
        $this->mdgEntityFactory = $mdgEntityFactory;
        $this->resourceModel = $resourceModel;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }

    /**
     * Edit entity
     *
     * @return Page|Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->mdgEntityFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getMdgEntityId()) {
                $this->messageManager->addErrorMessage(__('This entity no longer exists.'));
                $resultRedirect = $this->redirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('mdg_entity', $model);

        // 5. Build edit form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Entity'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getMdgEntityId() ? $model->getName() : __('New Entity'));

        return $resultPage;
    }
}
