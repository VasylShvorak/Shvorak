<?php


namespace Shvorak\Action\Model;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Uploader;
use Magento\Framework\Model\AbstractModel;
use Shvorak\Action\Model\Image;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class Action extends AbstractModel
{
    private $imageHelper;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        Image $imageHelper,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->imageHelper = $imageHelper;
    }

    protected function _construct()
    {
        $this->_init(\Shvorak\Action\Model\ResourceModel\Action::class);
    }

    public function getProductsChecked()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('action_products');
        if ($array === null) {
            $array = $this->getResource()->getProductsChecked($this);
            $this->setData('action_products', $array);
        }
        return $array;
    }

    public function getProductsLoad()
    {
        if (!$this->getId()) {
            return false;
        }
        return true;
    }

    /**
     * @param array $rawData
     * @return array
     */
    public function filterActionImageData(array $rawData)
    {
        return $this->imageHelper->filterActionImageData($rawData);
    }

    /**
     * @param string $imageName
     * @return string
     */
    public function checkUniqueImageName(string $imageName): string
    {
        return $this->imageHelper->checkUniqueImageName($imageName);
    }

    public function prepareImage()
    {
        $this->imageHelper->prepareImage($this);
    }

    public function checkImageExist($postData)
    {
        $data = $postData['general'];
        if (isset($data['id'])) {
            $imageName = $this->getResource()->getImageName($data['id']);
            if (isset($imageName) && $imageName == $data['image'][0]['name']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
