<?php
declare(strict_types=1);

namespace Mdg\AdminMenu\Block\Adminhtml\CustomEntity;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\AbstractBlock;

class Edit extends Container
{
    /**
     * Core registry
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'mdg_entity_id';
        $this->_controller = 'adminhtml_customEntity';
        $this->_blockGroup = 'Mdg_AdminMenu';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete'));
    }

    /**
     * Retrieve text for header element depending on loaded entity
     *
     * @return Phrase
     */
    public function getHeaderText(): Phrase
    {
        $entities = $this->_coreRegistry->registry('mdg_entity');
        if ($entities->getId()) {
            $entitiesTitle = $this->escapeHtml($entities->getName());
            return __("Edit Entity '%1'", $entitiesTitle);
        } else {
            return __('Add Entity');
        }
    }

    /**
     * Prepare layout
     *
     * @return AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('entity_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'entity_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'entity_content');
                }
            };
        ";

        return parent::_prepareLayout();
    }
}
