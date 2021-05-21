<?php


namespace Shvorak\Action\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Product extends AbstractDb
{
    public function _construct()
    {
        $this->_init('shvorak_action_products', 'id');
    }
}
