<?php
declare(strict_types=1);

namespace Mdg\Attributes\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class OptionsMultiSelect extends AbstractSource
{
    /**
     * @var $optionFactory
     */
    protected $optionFactory;

    /**
     * Get all options
     * @return array|null
     */
    public function getAllOptions(): ?array
    {
        $this->_options = [];
        $this->_options[] = ['label' => 'Label 1', 'value' => 'value 1'];
        $this->_options[] = ['label' => 'Label 2', 'value' => 'value 2'];

        return $this->_options;
    }
}
