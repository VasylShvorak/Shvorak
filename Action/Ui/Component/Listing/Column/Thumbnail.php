<?php

namespace Shvorak\Action\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Asset\Repository;

class Thumbnail extends Column
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Repository
     */
    private $assetRepo;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        Repository $assetRepo,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $url = $this->assetRepo->getUrl("Magento_Catalog::images/product/placeholder/thumbnail.jpg");
                if ($item[$fieldName] != '') {
                    $url = $this->storeManager->getStore()->getBaseUrl() . $item[$fieldName];
                }
                $item[$fieldName . '_src'] = $url;
            }
        }
        return $dataSource;
    }
}
