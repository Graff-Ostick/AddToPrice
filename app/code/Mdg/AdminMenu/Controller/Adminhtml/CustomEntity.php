<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Mdg\Models\Model\MdgEntityFactory;
use Mdg\AdminMenu\Logger\Logger;

/**
 * @property Logger $_logger
 */
class CustomEntity extends Action
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var MdgEntityFactory
     */
    protected $_mdgEntityFactory;

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
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_mdgEntityFactory = $mdgEntityFactory;
        $this->_logger = $logger;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }

    /**
     * @return bool
     */
    public function _isAllowed(): bool
    {
        return true;
    }
}
