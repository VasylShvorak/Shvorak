<?php


namespace Shvorak\Action\Model;


use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Uploader;
use Magento\Framework\Filesystem;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class Image
{
    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Filesystem$_filesystem,
        ImageUploader $imageUploader,
        StoreManagerInterface $storeManager
    ) {
        $this->_filesystem = $_filesystem;
        $this->imageUploader = $imageUploader;
        $this->storeManager = $storeManager;
    }


    public function prepareImage($object)
    {
        $attributeName = 'image';
        $value = $object->getData($attributeName);
        $imageName = $this->getUploadedImageName($value);
        if($imageName) {
            /** @var StoreInterface $store */
            $store = $this->storeManager->getStore();
            $baseMediaDir = $store->getBaseMediaDir();
            $newImgRelativePath = $this->imageUploader->moveFileFromTmp($imageName, true);
            $value[0]['url'] = '/' . $baseMediaDir . '/' . $newImgRelativePath;
            $value[0]['name'] = $value[0]['url'];

            $object->setData($attributeName, $value[0]['url']);
        }
        $object->setData($attributeName, $imageName);
        /*if ($imageName = $this->getUploadedImageName($value)) {
            $object->setData($attributeName, $imageName);
        } elseif (!is_string($value)) {
            $object->setData($attributeName, null);
        }*/
    }

    private function getUploadedImageName($value)
    {
        if (is_array($value) && isset($value[0]['name'])) {
            return $value[0]['name'];
        }

        return '';
    }
    /**
     * @param array $rawData
     * @return array
     */
    public function filterActionImageData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['image']) && is_array($data['image'])) {
            if (!empty($data['image']['delete'])) {
                $data['image'] = null;
            } else {
                if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                    $data['image'] = $data['image'][0]['name'];
                } else {
                    unset($data['image']);
                }
            }
        }
        return $data;
    }

    public function checkUniqueImageName(string $imageName): string
    {
        $mediaDirectory = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $imageAbsolutePath = $mediaDirectory->getAbsolutePath(
            $this->imageUploader->getBasePath() . DIRECTORY_SEPARATOR . $imageName
        );

        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $imageName = call_user_func([Uploader::class, 'getNewFilename'], $imageAbsolutePath);

        return $imageName;
    }
}
