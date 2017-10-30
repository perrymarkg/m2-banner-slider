<?php

namespace Prymag\BannerSlider\Ui\DataProvider;

use Prymag\BannerSlider\Model\ResourceModel\Banners\CollectionFactory;
use \Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

class BannerDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    private $pool;

    protected $loadedData;

    protected $dataPersistor;
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannersCollectionFactory,
        DataPersistorInterface $dataPersistor,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannersCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->pool = $pool; // This will be injected via etc/adminhtml/di.xml
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
                
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $banner) {
            // $banner->getId() will automatically map to the idfield based on what is defined in it's resource model, no need to use getBannerId(). ?
            $this->loadedData[$banner->getId()] = $banner->getData();
        }

        $data = $this->dataPersistor->get('prymag_banner'); 
        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getData();
            $this->dataPersistor->clear('prymag_banner');
        }

        // Dummy data format
        /* 
        $this->loadedData[$banner->getId()]['slides']['slides_listing'] = array(
            array(
                'id' => '55',
                'title' => 'Test Title',
                'position' => '0'
            ),
            array(
                'id' => '26 ',
                'title' => 'Test Title 2',
                'position' => '0'
            )
        ); */
      

        return $this->loadedData;
    }

    /**
     * Be sure to implement this fuction in order to trigger the AddSlides modifier
     * see Prymag\BannerSlier\Ui\DataProvider\Banners\Form\Modifiers\AddSlides.php
     *
     * @return void
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }

}