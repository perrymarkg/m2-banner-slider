<?php

namespace Prymag\BannerSlider\Ui\DataProvider;

use Prymag\BannerSlider\Model\ResourceModel\Slides\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use \Magento\Store\Model\StoreManagerInterface;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;

class SlideDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    protected $dataPersistor;

    protected $loadedData;

    protected $storeManager;

    protected $fileInfo;

    protected $filesystem;

    protected $mime;

    private $mediaDirectory;

    const SLIDE_PATH = '/bannerslider/';
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $slidesCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        FileSystem $filesystem,
        Mime $mime,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $slidesCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->mime = $mime;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $slide) {
            $this->loadedData[$slide->getId()] = $slide->getData();

            /**
             * Process image data
             * see Magento\Catalog\Model\Category\DataProvider::convertValues() for the functions involved
             */
            $image = $this->loadedData[$slide->getId()]['image'];
            if( !empty( $image ) ){
                $this->loadedData[$slide->getId()]['image'] = $this->buildImageData( $image );
            }
        }

        /**
         * this functions like a session?
         * see Prymag\BannerSlider\Adminhtml\Controller\Slides\Save
         */
        $data = $this->dataPersistor->get('prymag_slide'); 
        if (!empty($data)) {
            $slide = $this->collection->getNewEmptyItem();
            $slide->setData($data);
            $this->loadedData[$slide->getId()] = $slide->getData();
            $this->dataPersistor->clear('prymag_slide');
        }

        return $this->loadedData;
    }

    public function buildImageData( $image ) {
        $imageData = $this->getImageData($image);

        return array(
            array(
                'name' => $image,
                'url' => $this->getImageUrl( $image ),
                'size' => isset($imageData['size']) ? $imageData['size'] : 0,
                'type' => $this->getImageMimeData($image)
            )
        );
    }

    public function getImageUrl( $image )
    {
        $url = $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . 'bannerslider/' . $image;
        return $url;
    }

    public function getImageData( $image ) {
        return $this->getMediaDirectory()->stat( self::SLIDE_PATH . $image );
    }

    public function getImageMimeData( $image ){
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath( self::SLIDE_PATH . $image );
        return $this->mime->getMimeType($absoluteFilePath);
    }

    private function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }

    
   

}