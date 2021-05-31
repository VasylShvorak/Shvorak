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
        //set image path
        $action->setData(
            $this->getRequest()->getPostValue()['general']
        );
        if(isset($actionPostData['general']['image'])) {
            if (!$action->checkImageExist($actionPostData)) {
                $action->prepareImage();
            } else {
                $action->setData('image', $actionPostData['general']['image'][0]['name']);
            }
        }
        /*$actionData = $action->filterActionImageData($action->getData());
        $imageName = $action->checkUniqueImageName($actionData['image']);*/
        //$action->setData('image', $imageName);
        //save action products from grid
        if (isset($actionPostData['action_products'])
            && is_string($actionPostData['action_products'])
        ) {
            $products = json_decode($actionPostData['action_products'], true);
            $action->setPostedProducts($products);
        }
        $action->save();

        return $this->resultRedirectFactory->create()->setPath('action/index/index');
    }
}
