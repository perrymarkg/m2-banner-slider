<?php

namespace Prymag\BannerSlider\Model\ResourceModel\Banners;

/**
 * This is used for accessing the banner_slider relation. 
 * Can use Prymag\BannerSlider\Model\ResourceModel\Banners\Collection for querying the relation but,
 * encountered issue "ID" already exists,  looks like the $_idFieldName value needs to be unique for each items queried.
 * see https://magento.stackexchange.com/questions/91559/item-with-the-same-id-already-exist
 */

class BannerSlidesCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    
    /**
     * @var string
     */
    protected $_idFieldName = 'value_id';

    /**
     * Define table the model and resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init(			
            'Prymag\BannerSlider\Model\BannerSlides', // Model
            'Prymag\BannerSlider\Model\ResourceModel\BannerSlides'			
        );
    }

    /**
     * Get Banner Slides
     *
     * Joining tables 
     */
    public function getBannerSlides( $banner_id ){
        //$this->addFieldToFilter('banner_id', 'main_table.banner_id');
        
        $this->addFieldToSelect('slide_id', 'id');
        $this->addFieldToFilter('main_table.banner_id', $banner_id);
        return $this->getSelect()
        ->joinLeft(
            ['banners' => $this->getTable('prymag_banners')],
            'banners.banner_id = main_table.banner_id',
            []
        )
        ->joinLeft(
            ['slides' => $this->getTable('prymag_slides')],
            'slides.slide_id = main_table.slide_id',
            ['title','image']
        );
        
        
    }
    
}