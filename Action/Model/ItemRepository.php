<?php


namespace Shvorak\Action\Model;
use Shvorak\Action\Api\ActionRepositoryInterface;
use Shvorak\Action\Model\ResourceModel\Action\CollectionFactory;

class ItemRepository implements ActionRepositoryInterface
{

    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getList()
    {
        return $this->collectionFactory->create()->getItems();
    }

}
