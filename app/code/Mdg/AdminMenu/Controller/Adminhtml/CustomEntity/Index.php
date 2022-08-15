<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;
use Mdg\Models\Model\MdgEntityFactory;
use Mdg\AdminMenu\Logger\Logger;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Index extends CustomEntity
{
    /**
     * @var Context
     */
    private Context $context;
    /**
     * @var Registry
     */
    private Registry $coreRegistry;
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;
    /**
     * @var MdgEntityFactory
     */
    private MdgEntityFactory $mdgEntityFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param MdgEntityFactory $mdgEntityFactory
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        MdgEntityFactory $mdgEntityFactory,
        Logger $logger
    ) {
        parent::__construct($context, $coreRegistry, $resultPageFactory, $mdgEntityFactory, $logger);
        $this->context = $context;
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->mdgEntityFactory = $mdgEntityFactory;
    }

    /**
     * @return Page|void
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        /** @var Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Mdg Entity'));

        return $resultPage;
    }
}
