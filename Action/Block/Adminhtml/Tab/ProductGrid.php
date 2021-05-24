<?php


namespace Shvorak\Action\Block\Adminhtml\Tab;

use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\Store;

class ProductGrid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context    $context
     * @param \Magento\Backend\Helper\Data               $backendHelper
     * @param \Magento\Catalog\Model\ProductFactory      $productFactory
     * @param \Magento\Framework\Registry                $coreRegistry
     * @param \Magento\Framework\Module\Manager          $moduleManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Visibility|null                            $visibility
     * @param array                                      $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Visibility $visibility = null,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->productCollFactory = $productCollFactory;
        $this->coreRegistry = $coreRegistry;
        $this->moduleManager = $moduleManager;
        $this->_storeManager = $storeManager;
        $this->visibility = $visibility ?: ObjectManager::getInstance()->get(Visibility::class);
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * [_construct description]
     * @return [type] [description]
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('shvorak_action');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('entity_id')) {
            $this->setDefaultFilter(['in_action' => 1]);
        } else {
            $this->setDefaultFilter(['in_action' => 0]);
        }
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return array|null
     */
    public function getAction()
    {
        return $this->coreRegistry->registry('action');
    }

    /**
     * [get store id]
     *
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        if ($this->getAction()->getId()) {
            $this->setDefaultFilter(['in_action' => 1]);
        }
        $store = $this->_getStore();
        $collection = $this->productFactory->create()->getCollection()->addAttributeToSelect(
            'name'
        )->addAttributeToSelect(
            'sku'
        )->addAttributeToSelect(
            'visibility'
        )->addAttributeToSelect(
            'status'
        )->addAttributeToSelect(
            'price'
        )->setStore(
            $store
        )->joinField(
            'action_id',
            'shvorak_action_products',
            'action_id',
            'product_id=entity_id',
            'action_id=' . (int)$this->getRequest()->getParam('id', 0),
            'left'
        );

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_action') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_action',
            [
                'type' => 'checkbox',
                'name' => 'in_action',
                'values' => $this->_getSelectedProducts(),
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction',
                'index' => 'entity_id',
            ]
        );
        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'width' => '50px',
                'index' => 'entity_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
                'header_css_class' => 'col-sku',
                'column_css_class' => 'col-sku',
            ]
        );
        $store = $this->_getStore();
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
                'header_css_class' => 'col-price',
                'column_css_class' => 'col-price',
            ]
        );
        return parent::_prepareColumns();
    }
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('action/action/grid', ['_current' => true]);
    }
    /**
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = array_keys($this->getSelectedProducts());
        return $products;
    }
    /**
     * @return array
     */
    public function getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('action_products');
        if ($products === null) {
            $products = $this->getAction()->getProductsChecked();
            return $products;
        }
        return $products;
    }
}
