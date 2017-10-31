<?php

namespace Prymag\BannerSlider\Ui\DataProvider;

use Prymag\BannerSlider\Model\ResourceModel\Banners\CollectionFactory;
use Prymag\BannerSlider\Model\BannersFactory;
use \Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;

class BannerDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    private $pool;

    protected $loadedData;

    protected $dataPersistor;

    protected $request;

    protected $bannersFactory;

    protected $bannersCollectionFactory;
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannersCollectionFactory,
        DataPersistorInterface $dataPersistor,
        PoolInterface $pool,
        RequestInterface $request,
        BannersFactory $bannersFactory,
        array $meta = [],
        array $data = []
    ) {
        // Collection is required as definend in \Magento\Ui\DataProvider\AbstractDataProvider, point it to the appropriate collection
        $this->collection = $bannersCollectionFactory->create(); 
        // create a new collectionFactory to use later on.
        $this->bannersCollectionFactory = $bannersCollectionFactory; 
        // For testing use
        $this->bannersFactory = $bannersFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->pool = $pool; // This will be injected via etc/adminhtml/di.xml
        $this->request = $request; // To access request from the dataProvider
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
        $banner_id = $this->request->getParam( $this->requestFieldName );
        /*
        // This is another way of getting the data.
        $bannerId = $this->request->getParam( $this->requestFieldName );
        if( $bannerId ){
            $banner = $this->bannersFactory->load( $bannerId );
            $this->loadedData[$bannerId] = $banner->getData();
        }
        */
       
        $items = $this->collection->getItems();
                
        // This does not make sense at first, but it seems that $this->collection->getItems() get's a single item from the collection based on the requestFieldName
        // try throw new \Exception( count($items) ) and this will only show one item. so looks like this is the way to go
        foreach ($items as $banner) {
            // $banner->getId() will automatically map to the idfield based on what is defined in it's resource model, no need to use getBannerId(). ?
            $this->loadedData[$banner->getId()] = $banner->getBannerData();
        } 

        $data = $this->dataPersistor->get('prymag_banner'); 
        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getBannerData();
            $this->dataPersistor->clear('prymag_banner');
        }

        
        // add slides
        if( isset($this->loadedData[ $banner_id ] ) ){
            $collectionFactory = $this->bannersCollectionFactory->create();
            $collectionFactory->getBannerSlides( $banner_id );
            
            ob_start();
            foreach($collectionFactory as $i){
                var_dump($i->getData());
            }
            $dump = ob_get_clean();
            throw new \Exception( $dump ) ;
            //throw new \Exception($collectionFactory->getBannerSlides( $banner_id ));
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