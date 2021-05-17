<?php


namespace Shvorak\Action\Model\ResourceModel\Action;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Shvorak\Action\Model\Action;
use Shvorak\Action\Model\ResourceModel\Action as ActionResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected function _construct()
    {
        $this->_init(Action::class, ActionResource::class);
    }
}
