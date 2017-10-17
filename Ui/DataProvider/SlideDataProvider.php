<?php

namespace Prymag\BannerSlider\Ui\DataProvider;

use Prymag\BannerSlider\Model\ResourceModel\Slides\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class SlideDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    private $pool;

    protected $dataPersistor;

    protected $loadedData;
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $slidesCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $slidesCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
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
        }

        $data = $this->dataPersistor->get('slide_test'); // What does this do???
        if (!empty($data)) {
            $slide = $this->collection->getNewEmptyItem();
            $slide->setData($data);
            $this->loadedData[$slide->getId()] = $slide->getData();
            $this->dataPersistor->clear('slide_test');
        }

        return $this->loadedData;
    }
   

}