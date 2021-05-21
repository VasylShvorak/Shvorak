<?php

declare(strict_types=1);

namespace Shvorak\Action\Ui\Component\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Shvorak\Action\Model\ResourceModel\Product\Listing\CollectionFactory;

/**
 * Class CustomDataProvider
 */
class CustomDataProvider extends AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->collection->getItems();
        //return [];
    }
}
