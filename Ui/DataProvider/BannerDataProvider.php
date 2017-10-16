<?php

namespace Prymag\BannerSlider\Ui\DataProvider;

use Prymag\BannerSlider\Model\ResourceModel\Banners\CollectionFactory;


class BannerDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannersCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannersCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $banners) {
            /** 
             * banner_details - this should contain the same fieldset name that will be using this dataprovider 
             * allows mapping the data automatically
             * see view/adminhtml/ui_component/banners_form.xml dataSource
             * */
            $this->loadedData[$contact->getId()]['banner_details'] = $banners->getData();
        }


        return $this->loadedData;

    }
}