<?php


namespace Shvorak\Action\Controller\Adminhtml\Action;


use Magento\Framework\App\Action\HttpPostActionInterface;
use Shvorak\Action\Model\ActionFactory;
use Shvorak\Action\Model\ProductFactory;

class Delete extends \Magento\Cms\Controller\Adminhtml\Block implements HttpPostActionInterface
{
    private $actionFactory;

    private $actionProductsFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        ActionFactory $actionFactory,
        ProductFactory $actionProductsFactory
    ) {
        parent::__construct($context, $coreRegistry);
        $this->actionFactory = $actionFactory;
        $this->actionProductsFactory = $actionProductsFactory;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->actionFactory->create();
                $model->load($id);
                $model->delete();
                //delete related products
                $products = $this->actionProductsFactory->create();
                $products->deleteActionProducts($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the action.'));
                // go to grid
                return $resultRedirect->setPath('action/index/index');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

    }
}
