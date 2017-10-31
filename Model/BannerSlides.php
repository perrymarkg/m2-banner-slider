<?php

namespace Prymag\BannerSlider\Model;

use Magento\Framework\DataObject\IdentityInterface;

class BannerSlides extends \Magento\Framework\Model\AbstractModel implements IdentityInterface {

    const CACHE_TAG = 'prymag_banner_slider_relation';
    
    protected $_cacheTag = 'prymag_banner_slider_relation';
    
    protected $_eventPrefix = 'prymag_banner_slider_relation';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('Prymag\BannerSlider\Model\ResourceModel\BannerSlides');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

}