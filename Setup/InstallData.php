<?php
/**
 * A Magento 2 module named Prymag/BannerSlider
 * Copyright (C) 2017  
 * 
 * This file is part of Prymag/BannerSlider.
 * 
 * Prymag/BannerSlider is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prymag\BannerSlider\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    private $bannerFactory;

    private $slidesFactory;

    public function __construct(\Prymag\BannerSlider\Model\BannersFactory $bannersFactory, \Prymag\BannerSlider\Model\SlidesFactory $slidesFactory){
        $this->bannersFactory = $bannersFactory;
        $this->slidesFactory = $slidesFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        //Your install script
        $banners = array(
            array(
                'title' => 'Sample Banner 1'
            ),
            array(
                'title' => 'Sample Banner 2'
            )
        );

        $slides = array(
            array(
                'title' => 'Banner One',
                'content' => 'Lorem Ipsum',
            ),
            array(
                'title' => 'Banner Two',
                'content' => 'Lorem Ipsums',
            )
        );
        
        foreach($banners as $k => $b){
            $banner_id = $this->createBanner()->setData($b)->save()->getId();
            $this->createSlides()->setData( $slides[$k] )->save();
        }
    }

    public function createBanner(){
        return $this->bannersFactory->create();
    }

    public function createSlides(){
        return $this->slidesFactory->create();
    }
}
