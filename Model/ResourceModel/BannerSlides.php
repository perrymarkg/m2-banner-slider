<?php

namespace Prymag\BannerSlider\Model\ResourceModel;

class BannerSlides extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    
    /**
     * Define table for this resource and the primary key
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('prymag_banner_slider_relation', 'value_id');
    }
       
}