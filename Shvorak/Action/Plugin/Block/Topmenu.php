<?php


namespace Shvorak\Action\Plugin\Block;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Store\Model\StoreManagerInterface;

class Topmenu
{
    const URL_PATH_ACTION_LIST = 'action/index/index';
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var NodeFactory
     */
    protected $nodeFactory;

    public function __construct(
        NodeFactory $nodeFactory,
    StoreManagerInterface $storeManager
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->storeManager = $storeManager;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    protected function getNodeAsArray()
    {
        return [
            'name' => __('Actions List'),
            'id' => 'actions-list',
            'url' => $this->storeManager->getStore()->getBaseUrl() . self::URL_PATH_ACTION_LIST,
            'has_active' => false,
            'is_active' => false // (expression to determine if menu item is selected or not)
        ];
    }
}
