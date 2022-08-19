<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Controller\Adminhtml\CustomEntity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Mdg\Models\Model\MdgEntityFactory;

/**
 * Delete CMS page action.
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mdg_AdminMenu::entity_delete';

    /**
     * @var MdgEntityFactory
     */
    private MdgEntityFactory $mdgEntityFactory;

    /**
     * @param Context           $context
     * @param MdgEntityFactory  $mdgEntityFactory
     */
    public function __construct(
        Context             $context,
        MdgEntityFactory    $mdgEntityFactory
    ) {
        parent::__construct($context);
        $this->mdgEntityFactory = $mdgEntityFactory;
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('mdg_entity_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $title = "";
            try {
                // init model and delete
//                $model = $this->_objectManager->create(\Magento\Cms\Model\Page::class);
                $model = $this->mdgEntityFactory->create();
                $model->load($id);

                $name = $model->getName();
                $model->delete();

                // display success message
                $this->messageManager->addSuccessMessage(__('The page has been deleted.'));

                // go to grid
                $this->_eventManager->dispatch('mdg_admin_menu_on_delete', [
                    'title' => $name,
                    'status' => 'success'
                ]);

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'mdg_admin_menu_on_delete',
                    ['title' => $title, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $id]);
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a entity to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
