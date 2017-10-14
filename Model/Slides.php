<?php

namespace Prymag\BannerSlider\Model;
use Magento\Framework\DataObject\IdentityInterface;

class Slides extends \Magento\Framework\Model\AbstractModel implements  IdentityInterface {

    const CACHE_TAG = 'prymag_banner_slides';
    
    protected $_cacheTag = 'prymag_banner_slides';
    
    protected $_eventPrefix = 'prymag_banner_slides';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('Prymag\BannerSlider\Model\ResourceModel\Slides');
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