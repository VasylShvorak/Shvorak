<?php


namespace Shvorak\Action\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Product extends AbstractDb
{
    public function _construct()
    {
        $this->_init('shvorak_action_products', 'id');
    }



    public function deleteActionProducts($actionId)
    {
        $connection = $this->getConnection();
        $cond = ['action_id = ?' => $actionId];
        $connection->delete($this->getActionProductTable(), $cond);
    }

    private function getActionProductTable()
    {
        return $this->actionProductTable = $this->getTable('shvorak_action_products');
    }
}
