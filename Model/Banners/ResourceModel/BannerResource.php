<?php

namespace Prymag\BannerSlider\Model\Banners\ResourceModel;

class BannerResource extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    
    /**
     * Define table for this resource and the primary key
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('banner_slider', 'banner_id');
    }
    
}