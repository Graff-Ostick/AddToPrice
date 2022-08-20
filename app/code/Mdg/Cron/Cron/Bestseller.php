<?php
declare(strict_types=1);

namespace Mdg\Cron\Cron;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Bestseller
{

    /**
     * @var BestSellersCollectionFactory
     */
    public BestSellersCollectionFactory $collectionFactory;

    /**
     * @var ProductRepositoryInterface
     */
    public ProductRepositoryInterface $productRepository;

    /**
     * @param BestSellersCollectionFactory $collectionFactory
     * @param Filesystem $filesystem
     * @param ProductRepositoryInterface $productRepository
     * @throws FileSystemException
     */
    public function __construct(
        BestSellersCollectionFactory    $collectionFactory,
        Filesystem                      $filesystem,
        ProductRepositoryInterface      $productRepository
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
    }

    /**
     * Log data
     * @return void
     * @throws FileSystemException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $collection = $this->getBestSellers();
        $data = $this->prepareData($collection);

        $filepath = "media/export/day_bestseller.csv";
        $this->directory->create('media/export');
        $stream = $this->directory->openFile($filepath, 'w+');
        $stream->lock();

        $header = ["Sku", "Name", "Price", "Day sell qty",  "Date"];
        $stream->writeCsv($header);

        foreach ($data as $item) {
            $stream->writeCsv($item);
        }
    }

    /**
     *  Get best sellers product
     * @return Collection
     */
    public function getBestSellers()
    {
        return $this->collectionFactory->create()->setPeriod('day');
    }

    /**
     * return prepared data to logger
     * @param $collection
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareData($collection): array
    {
        $dataArray = [];
        foreach ($collection as $item) {
            $dataArray[$item->getProductId()]['sku'] =  $this->productRepository->getById($item->getProductId())->getSku();
            $dataArray[$item->getProductId()]['name'] = $item->getProductName();
            $dataArray[$item->getProductId()]['price'] = $item->getProductPrice();
            $dataArray[$item->getProductId()]['qty'] = $item->getQtyOrdered();
            $dataArray[$item->getProductId()]['date'] = $item->getPeriod();
        }
        return $dataArray;
    }
}
