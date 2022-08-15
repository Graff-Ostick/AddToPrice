<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Block\Adminhtml\CustomEntity\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Json\EncoderInterface;

class Tabs extends WidgetTabs
{
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        Session $authSession,
        array $data = []
    ) {
        parent::__construct($context, $jsonEncoder, $authSession, $data);
        $this->setMdgEntityId('entity_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setName(__('Entity Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'entity_info',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Mdg\AdminMenu\Block\Adminhtml\CustomEntity\Edit\Tab\Info'
                )->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }
}
