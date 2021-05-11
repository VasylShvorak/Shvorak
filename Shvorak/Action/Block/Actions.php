<?php


namespace Shvorak\Action\Block;

use Magento\Framework\View\Element\Template;
use Shvorak\Action\Model\Action;
use Shvorak\Action\Model\ResourceModel\Action\Collection;
use Shvorak\Action\Model\ResourceModel\Action\CollectionFactory;

class Actions extends Template
{
    private $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Action[]
     */
    public function getItems()
    {
        return $this->collectionFactory->create()->getItems();
    }
}
