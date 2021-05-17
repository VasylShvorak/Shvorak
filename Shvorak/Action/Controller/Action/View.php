<?php


namespace Shvorak\Action\Controller\Action;


use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;


class View extends Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
