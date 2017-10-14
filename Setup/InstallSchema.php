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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $bannersTable = $installer->getTable('prymag_banners');
        $bannerSlidesTable = $installer->getTable('prymag_slides');

        if ($installer->getConnection()->isTableExists($bannersTable) != true) {
            $table = $installer->getConnection()
            ->newTable($installer->getTable($bannersTable))
            ->addColumn(
                'banner_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Banner ID'
            )
            ->addColumn('title', Table::TYPE_TEXT, 100, ['nullable' => true, 'default' => null])
            ->addColumn('options', Table::TYPE_TEXT, 255, ['nullable' => true], 'Banner Options')
            ->addColumn('created_at', Table::TYPE_DATETIME, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Creation Time')
            ->addColumn('updated_at', Table::TYPE_DATETIME, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Update Time')            
            ->setComment('Prymag/Banners Table');

            $installer->getConnection()->createTable($table);   
        }


        if ($installer->getConnection()->isTableExists($bannerSlidesTable) != true) {
            $table = $installer->getConnection()
            ->newTable($installer->getTable($bannerSlidesTable))
            ->addColumn(
                'slide_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Slide ID'
            )
            ->addColumn('title', Table::TYPE_TEXT, 100, ['nullable' => true, 'default' => null])
            ->addColumn('content', Table::TYPE_TEXT, null, ['nullable' => true], 'Slide Content')
            ->addColumn('image', Table::TYPE_TEXT, 512, ['nullable' => true])
            ->addColumn('button_title', Table::TYPE_TEXT, 256, ['nullable' => true])
            ->addColumn('button_url', Table::TYPE_TEXT, 512, ['nullable' => true])
            ->addColumn('is_active', Table::TYPE_TEXT, 512, ['nullable' => true])
            ->addColumn('order', Table::TYPE_TEXT, 512, ['nullable' => true])
            ->addColumn('created_at', Table::TYPE_DATETIME, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Creation Time')
            ->addColumn('updated_at', Table::TYPE_DATETIME, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Update Time')            
            ->setComment('Prymag/Slides Table');

            $installer->getConnection()->createTable($table);
            
        }

        $setup->endSetup();
    }
}
