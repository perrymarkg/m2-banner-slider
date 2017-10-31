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

    /**
     * DO NOT DELETE
     * Test code
     * This works but will encounter ID already exists error.
     * $_idFieldName or 'banner_id' value needs to be unique for each items queried.
     * create separate collection for handling relationship see Prymag\BannerSlider\Model\ResourceModel\Banners\BannerSlidesCollection
     */
    public function getBannerSlides( $banner_id ){
        //$this->addFieldToFilter('banner_id', 'main_table.banner_id');
        
        $this->addFieldToFilter('main_table.banner_id', $banner_id);
        return $this->getSelect()
        ->joinLeft(
            ['relation' => $this->getTable('prymag_banner_slider_relation')],
            'relation.banner_id = main_table.banner_id',
            ['position']
        )
        ->joinLeft(
            ['slides' => $this->getTable('prymag_slides')],
            'slides.slide_id = relation.slide_id',
            ['title','image']
        );
        
        
    }
    
}