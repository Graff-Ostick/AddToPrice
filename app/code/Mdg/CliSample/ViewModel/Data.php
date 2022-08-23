<?php
declare(strict_types=1);

namespace Mdg\CliSample\ViewModel;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Online\Grid\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class for get data for transfer to cli
 */
class Data
{
    /**
     * @var CustomerFactory
     */
    public CustomerFactory $customerFactory;
    /**
     * @var CollectionFactory
     */
    public CollectionFactory $onlineCollFactory;

    /**
     * @param CustomerFactory $customerFactory
     * @param CollectionFactory $onlineCollFactory
     * @param Filesystem $filesystem
     * @throws FileSystemException
     */
    public function __construct(
        CustomerFactory                 $customerFactory,
        CollectionFactory               $onlineCollFactory,
        Filesystem                      $filesystem
    ) {
        $this->customerFactory = $customerFactory;
        $this->onlineCollFactory = $onlineCollFactory;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
    }

    /**
     * Return customers registers per 24 hour
     * @return mixed
     */
    public function getCustomerRegisteredPerDay()
    {
        $dayBefore = date('Y-m-d H:m:s', time()-86400);
        return $this->customerFactory->create()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("created_at", ["from" => $dayBefore])
            ->load();
    }

    /**
     * Return Customer collection with inline customers
     * @return mixed
     */
    public function getOnlineCustomersCollection()
    {
        $customerOnlineIds = [];
        foreach ($this->onlineCollFactory->create() as $item) {
            $customerOnlineIds[] = $item->getCustomerId();
        }
        return $this->customerFactory->create()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("entity_id", ["in" => $customerOnlineIds])
            ->load();
    }

    /**
     * Return customer collection who have is_active attribute equal 0
     * @return AbstractDb|AbstractCollection|null
     */
    public function getBlockedUsers()
    {
        return $this->customerFactory->create()->getCollection()->addFilter('is_active', 0);
    }

    /**
     * Save in files info
     * @param $collection
     * @param $fileName
     * @return void
     * @throws FileSystemException
     */
    public function saveInCsv($collection, $fileName)
    {
        $filepath = "media/export/mdg_" . $fileName . ".csv";
        $this->directory->create('media/export');
        $stream = $this->directory->openFile($filepath, 'w+');
        $stream->lock();

        $header = ["Customer Name"];
        $stream->writeCsv($header);

        foreach ($collection as $item) {
            $stream->writeCsv([$item->getFirstname()]);
        }
    }
}
