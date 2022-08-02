<?php
declare(strict_types=1);

namespace Mdg\ExampleModule\Setup;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    /**
     * Construct
     *
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1') < 0) {
            $page = $this->_pageFactory->create();
            $page->setTitle('Example CMS page')
                ->setIdentifier('example-cms-page')
                ->setIsActive(true)
                ->setPageLayout('4columns')
                ->setStores([0])
                ->setContent('sample 4 columns custom page')
                ->save();
        }

        $setup->endSetup();
    }
}
