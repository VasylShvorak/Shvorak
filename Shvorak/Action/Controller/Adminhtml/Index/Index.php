<?php


namespace Shvorak\Action\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        /** @var Raw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents('Greetings Admin!');
        return $result;
    }
}
