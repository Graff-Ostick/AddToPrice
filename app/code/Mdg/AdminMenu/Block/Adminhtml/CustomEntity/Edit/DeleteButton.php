<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Block\Adminhtml\CustomEntity\Edit;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getMdgEntityId()) {
            $data = [
                'label' => __('Delete Page'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Url to send delete requests to.
     *
     * @return string
     * @throws LocalizedException
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['page_id' => $this->getMdgEntityId()]);
    }
}
