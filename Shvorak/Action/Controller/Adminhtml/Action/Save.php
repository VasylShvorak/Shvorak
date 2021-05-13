<?php


namespace Shvorak\Action\Controller\Adminhtml\Action;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Shvorak\Action\Model\ActionFactory;

class Save extends Action
{
    private $actionFactory;

    public function __construct(
        Context $context,
        ActionFactory $actionFactory
    ) {
        parent::__construct($context);
        $this->actionFactory = $actionFactory;
    }

    public function execute()
    {
        $this->actionFactory->create()->setData(
            $this->getRequest()->getPostValue()['general']
        )->save();
        return $this->resultRedirectFactory->create()->setPath('action/index/index');
    }
}
