<?php


namespace Shvorak\Action\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Action extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('shvorak_action', 'id');
    }
}
