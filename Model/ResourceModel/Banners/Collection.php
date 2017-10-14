<?php

namespace Prymag\BannerSlider\Model\ResourceModel\Banners;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    
    /**
     * @var string
     */
    protected $_idFieldName = 'banner_id';

    /**
     * Define table the model and resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init(			
            'Prymag\BannerSlider\Model\Banners', // Model
            'Prymag\BannerSlider\Model\ResourceModel\Banners'			
        );
    }
    
}