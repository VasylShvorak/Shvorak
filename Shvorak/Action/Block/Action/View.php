<?php


namespace Shvorak\Action\Block\Action;
use Magento\Framework\View\Element\Template;
use Shvorak\Action\Model\ActionFactory;

class View extends Template
{
    /** @var ActionFactory */
    private $actionFactory;

    public function __construct(
        Template\Context $context,
        ActionFactory $actionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->actionFactory = $actionFactory;
    }

    public function getAction()
    {
        $id = $this->getId();
        return $this->actionFactory->create()->load($id);
    }

    private function getId()
    {
        return $this->getRequest()->getParam('id');
    }
}
