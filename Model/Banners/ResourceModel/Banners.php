<?php

namespace Prymag\BannerSlider\Model\Banners\ResourceModel;

class Banners extends \Magento\Framework\Model\AbstractModel {

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('Prymag\BannerSlider\Model\Banners\ResourceModel\BannerResource');
    }

}
