<?php


namespace Shvorak\Action\Controller\Adminhtml\Action;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
