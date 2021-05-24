<?php


namespace Shvorak\Action\Controller\Adminhtml\Action;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Shvorak\Action\Model\ActionFactory;
use Shvorak\Action\Model\ProductFactory;

class Save extends Action
{
    private $actionFactory;

    private $actionProductsFactory;

    public function __construct(
        Context $context,
        ActionFactory $actionFactory,
        ProductFactory $actionProductsFactory
    ) {
        parent::__construct($context);
        $this->actionFactory = $actionFactory;
        $this->actionProductsFactory = $actionProductsFactory;
    }

    public function execute()
    {
        $actionPostData = $this->getRequest()->getPostValue();
        $action = $this->actionFactory->create();
        $actionProducts = $this->actionProductsFactory->create();
        $action->setData(
            $this->getRequest()->getPostValue()['general']
        );

        //save action products from grid
        if (isset($actionPostData['action_products'])
            && is_string($actionPostData['action_products'])
        ) {
            $products = json_decode($actionPostData['action_products'], true);
            $action->setPostedProducts($products);
        }
        $action->save();

        //save checked products in grid
        /*if (isset($actionPostData['action_products'])
            && is_string($actionPostData['action_products'])
        ) {
            $products = json_decode($actionPostData['action_products'], true);
            $actionProducts->setPostedProducts($products);
        }*/

        return $this->resultRedirectFactory->create()->setPath('action/index/index');
    }
}
