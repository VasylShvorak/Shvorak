<?php


namespace Shvorak\Action\Controller\Adminhtml\Action;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;
use Shvorak\Action\Model\ActionFactory;

class Grid extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    private $actionFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * Grid constructor.
     * @param Context $context
     * @param RawFactory $resultRawFactory
     * @param LayoutFactory $layoutFactory
     * @param ActionFactory $actionFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        Rawfactory $resultRawFactory,
        LayoutFactory $layoutFactory,
        ActionFactory $actionFactory,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        $this->actionFactory = $actionFactory;
        $this->registry = $registry;
    }
    /**
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $action = $this->actionFactory->create();
        $actionId = (int)$this->getRequest()->getParam('id', false);
        $this->registry->register('action', $action->load($actionId));
        $this->registry->register('current_action', $action->load($actionId));
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                'Shvorak\Action\Block\Adminhtml\Tab\ProductGrid',
                'shvorak_action.productgrid'
            )->toHtml()
        );
    }
}
