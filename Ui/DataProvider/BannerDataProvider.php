<?php

namespace Prymag\BannerSlider\Ui\DataProvider;

use Prymag\BannerSlider\Model\ResourceModel\Banners\CollectionFactory;
use \Magento\Ui\DataProvider\Modifier\PoolInterface;

class BannerDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    private $pool;
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannersCollectionFactory,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannersCollectionFactory->create();
        $this->pool = $pool; // This will be injected via etc/adminhtml/di.xml
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }
        return $this->data;
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