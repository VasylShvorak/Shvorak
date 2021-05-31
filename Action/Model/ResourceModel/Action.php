<?php

namespace Shvorak\Action\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\Category;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Action extends AbstractDb
{
    /**
     * Action products table name
     *
     * @var string
     */
    protected $actionProductTable;

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

    /**
     * Category product table name getter
     *
     * @return string
     */
    public function getActionProductTable()
    {
        return $this->actionProductTable = $this->getTable('shvorak_action_products');

    }

    /**
     * Process category data after save category object
     *
     * Save related products ids and update path value
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\DataObject $object)
    {
        /**
         * Add identifier for new category
         */
        if (substr((string)$object->getPath(), -1) == '/') {
            $object->setPath($object->getPath() . $object->getId());
            $this->_savePath($object);
        }
        $this->_saveActionProducts($object);
        return parent::_afterSave($object);
    }

    /**
     * Save category products relation
     *
     * @param \Shvorak\Action\Model\Action $action
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _saveActionProducts($action)
    {
        //$action->setIsChangedProductList(false);
        $id = $action->getId();
        /**
         * new category-product relationships
         */
        $products = $action->getPostedProducts();

        /**
         * Example re-save category
         */
        if ($products === null) {
            return $this;
        }

        /**
         * old category-product relationships
         */
        $oldProducts = $action->getProductsChecked();

        $insert = array_diff_key($products, $oldProducts);
        $delete = array_diff_key($oldProducts, $products);

        /**
         * Find product ids which are presented in both arrays
         * and saved before (check $oldProducts array)
         */
        $update = array_intersect_key($products, $oldProducts);
        $update = array_diff_assoc($update, $oldProducts);

        $connection = $this->getConnection();

        /**
         * Delete products from category
         */
        if (!empty($delete)) {
            $cond = ['product_id IN(?)' => array_keys($delete), 'action_id=?' => $id];
            $connection->delete($this->getActionProductTable(), $cond);
        }

        /**
         * Add products to category
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId => $actionId) {
                $data[] = [
                    'action_id' => (int)$id,
                    'product_id' => (int)$productId,
                ];
            }
            $connection->insertMultiple($this->getActionProductTable(), $data);
        }
    }

    public function getImageName($id)
    {
        $connection = $this->getConnection();
        $bind = ['id' => $id];
        $select = $connection->select()->from($this->getTable('shvorak_action'),
        ['image']
        )->where('id = :id');
        return $connection->fetchOne($select,$bind);
    }
}
