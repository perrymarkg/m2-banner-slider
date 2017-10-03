<?php

namespace Prymag\BannerSlider\Model\Banners\ResourceModel;

class BannerCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    
    /**
     * Define table the model and resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init(			
            'Prymag\BannerSlider\Model\Banners\ResourceModel\Banners', // Model
            'Prymag\BannerSlider\Model\Banners\ResourceModel\BannerResource'			
        );
    }
    
}