<?php

namespace Shvorak\Action\Controller\Adminhtml\Action;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Shvorak\Action\Model\ActionFactory;
use Magento\Framework\Registry;

class NewAction extends Action
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param ActionFactory $actionFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        ActionFactory $actionFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->actionFactory = $actionFactory;
        $this->registry = $registry;
    }

    public function execute()
    {
        $actionId = (int)$this->getRequest()->getParam('id', false);
        if (!$actionId) {
            $actionId = (int)$this->getRequest()->getParam('entity_id', false);
        }
        $action = $this->actionFactory->create();
        $this->registry->register('action', $action);
        $this->registry->register('current_action', $action);
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
