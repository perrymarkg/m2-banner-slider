<?php

namespace Prymag\BannerSlider\Model\ResourceModel;

class Banners extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    
    protected $bannerSliderRelation;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ){
        parent::__construct($context);
        $this->bannerSliderTable = $this->getTable('prymag_banner_slider_relation');
    }

    /**
     * Define table for this resource and the primary key
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('prymag_banners', 'banner_id');
    }
       
}