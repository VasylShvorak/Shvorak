<?php


namespace Shvorak\Action\Model;


use Magento\Framework\Model\AbstractModel;


class Action extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Shvorak\Action\Model\ResourceModel\Action::class);
    }

    public function getProductsChecked()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('action_products');
        if ($array === null) {
            $array = $this->getResource()->getProductsChecked($this);
            $this->setData('action_products', $array);
        }
        return $array;
    }

    public function getProductsLoad()
    {
        if (!$this->getId()) {
            return false;
        }
        return true;
    }
}
