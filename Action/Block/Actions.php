<?php

namespace Shvorak\Action\Block;

use Magento\Framework\View\Element\Template;
use Shvorak\Action\Model\Action;
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

    /**
     * @return string
     */
    public function getActionUrl($param)
    {
        /** TODO: implementation $_product->getProductUrl() in model
         * \Magento\Catalog\Model\Product
         */
        return $this->getUrl('action/action/view', ['id' => $param]);
    }

    public function getImage()
    {
        /** TODO: $block->getImage($_product, $image)->toHtml() from
         * app/code/Magento/Catalog/view/frontend/templates/product/list.phtml
         */
        return '';
    }
}
