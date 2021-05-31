<?php

namespace Shvorak\Action\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    public function getData()
    {
        $result = [];
        foreach ($this->collection->getItems() as $item) {
            $itemData = $item->getData();
            $imageName = $itemData['image']; // Your database field
            unset($itemData['image']);
            $itemData['image'] = [
                [
                    'name'  =>  $imageName,
                    'url'   =>  $item->getImage() // Should return a URL to view the image. For example, http://domain.com/pub/media/../../imagename.jpeg
                ]
            ];
            $result[$item->getId()]['general'] = $itemData;
        }
        return $result;
    }
}
