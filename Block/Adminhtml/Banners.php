<?php

namespace Prymag\BannerSlider\Block\Adminhtml;

class Banners extends \Magento\Backend\Block\Widget\Grid\Container {
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_bannerss';
        $this->_blockGroup = 'Prymag_BannerSlider';
        $this->_headerText = __('Banners');
        $this->_addButtonLabel = __('Create New Banner');
        parent::_construct();
    }
}