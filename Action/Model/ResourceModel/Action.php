<?php

namespace Shvorak\Action\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Action extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('shvorak_action', 'id');
    }

    public function getProductsChecked($action)
    {
        //problem on edit action here
        $select = $this->getConnection()->select()->from(
            $this->getTable('shvorak_action_products'),
            ['product_id', 'action_id']
        )->where(
            "{$this->getTable('shvorak_action_products')}.action_id = ?",
            $action->getId()
        );

        //return $select;
        $bind = ['action_id' => (int)$action->getId()];
        //return $this->getConnection()->fetchAll($select, $bind);

        return $this->getConnection()->fetchPairs($select, $bind);
    }
}
