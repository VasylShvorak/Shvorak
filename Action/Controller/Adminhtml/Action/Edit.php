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

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        Context $context,
        ActionFactory $actionFactory,
        PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->actionFactory = $actionFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
    }

    public function execute()
    {
        $action = $this->actionFactory->create();
        $actionId = (int)$this->getRequest()->getParam('id', false);
        $this->registry->register('action', $action->load($actionId));
        $this->registry->register('current_action', $action->load($actionId));
        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Actions'));
        $resultPage->getConfig()->getTitle()->prepend($action->getId() ? $action->getName() : __('New Block'));
        return $resultPage;
    }
}
