<?php


namespace Shvorak\Action\Model;


use Magento\Framework\Model\AbstractModel;


class Action extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Shvorak\Action\Model\ResourceModel\Action::class);
    }
}
