<?php

namespace Prymag\BannerSlider\Model\ResourceModel\Slides;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    
    /**
     * Define table the model and resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init(			
            'Prymag\BannerSlider\Model\Slides', // Model
            'Prymag\BannerSlider\Model\ResourceModel\Slides'			
        );
    }
    
}