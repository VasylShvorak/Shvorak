<?php


namespace Shvorak\Action\Model;
use Magento\Framework\Model\AbstractModel;

class Product extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Shvorak\Action\Model\ResourceModel\Product::class);
    }

    public function getProducts()
    {
        $this->_resource->getLoadSelect('action_id', $this->getActionId(), $this);
    }

    public function deleteActionProducts($actionId)
    {
        $this->getResource()->deleteActionProducts($actionId);
    }
}
