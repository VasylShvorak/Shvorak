<?php

namespace Shvorak\Action\Controller\Adminhtml\Action;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Shvorak\Action\Model\ActionFactory;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    private $actionFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        ActionFactory $actionFactory,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->actionFactory = $actionFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->actionFactory->create();

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Actions'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Block'));
        return $resultPage;
    }
}
