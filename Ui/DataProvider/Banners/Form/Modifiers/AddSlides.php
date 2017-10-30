<?php

namespace Prymag\BannerSlider\Ui\DataProvider\Banners\Form\Modifiers;

use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Framework\Phrase;
use Magento\Ui\Component\DynamicRows;
/**
 * This is injected via di.xml, see etc/adminhtml/di.xml
 * see m2 doc about PHP modifiers
 * 
 */
class AddSlides implements \Magento\Ui\DataProvider\Modifier\ModifierInterface {
    
    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    public function modifyMeta(array $meta)
    {
        $meta['banner_slides'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Banner Slides'),
                        'sortOrder' => 50,
                        'collapsible' => true,
                        'componentType' => 'fieldset',
                        'dataScope' => ''
                    ]
                ]
            ],
            'children' => [
               
                'banner_slides_button' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'formElement' => 'container',
                                'componentType' => 'container',
                                'label' => false,
                                'component' => 'Magento_Ui/js/form/components/button',
                                'title' => 'Add Slides',
                                'provider' => null,
                                'actions' => [
                                    [
                                        'targetName' => '${ $.parentName}.banner_slides_modal', // target the modal "config name". refer to #Ref1 of this file
                                        'actionName' => 'openModal' // can be openModal or toggleModal, why?
                                    ],
                                    [
                                        'targetName' => '${ $.parentName}.banner_slides_modal.slides_grid_content', // target the modal grid content. refer to #Ref2 this file
                                        'actionName' => 'render'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'banner_slides_modal' => [ //#Ref1 
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'modal',
                                'dataScope' => '',
                                'options' => [
                                    'title' => 'Select Slides',
                                    'buttons' => [
                                        [
                                            'text' => __('Cancel'),
                                            'actions' => [
                                                'closeModal'
                                            ]
                                        ],
                                        [
                                            'text' => __('Add Selected Slides'),
                                            'class' => 'action-primary',
                                            'actions' => [
                                                [
                                                    'targetName' => 'index = slides_grid_content',
                                                    'actionName' => 'save'
                                                ],
                                                'closeModal'
                                            ]
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ],
                    'children' => [
                        'slides_grid_content' => [ // #Ref2
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'autoRender' => false,
                                        'componentType' => 'insertListing',
                                        // This is where the insertListing will be adding it's selected content in the dataSource
                                        // it is adding it as data.dataScope, in this case data.slides_listing.
                                        'dataScope' => 'slides_listing',
                                        'externalProvider' => 'slides_listing.slides_listing.slide_data_source', // name of the datasource for the listing, see view/adminhtml/ui_component. Read notes on file.
                                        'selectionsProvider' => 'slides_listing.slides_listing.prymag_slide_columns.ids', // the column id selection on the
                                        'ns' => 'slides_listing', // the namespace
                                        'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                        'realTimeLink' => true,
                                        'dataLinks' => [
                                            'imports' => false,
                                            'exports' => true
                                        ],
                                        'behaviourType' => 'simple',
                                        'externalFilterMode' => true,                                        
                                    ]                                            
                                ]
                            ]
                        ]
                    ]
                ], // End banner_slides_modal
                
                'slides_listing' => [ // this is where the data from modal will be passed to
                    'arguments' => [
                        'data' => [ // This will build the main table header
                            'config' => [
                                'additionalClasses' => 'admin__field-wide',
                                'componentType' => DynamicRows::NAME,
                                'label' => null,
                                'columnsHeader' => true,
                                'columnsHeaderAfterRender' => false,
                                'renderDefaultRecord' => false,
                                'template' => 'ui/dynamic-rows/templates/grid',
                                'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows-grid',
                                'addButton' => false,
                                'recordTemplate' => 'record', // default to record
                                // dataScope = is where dynamicRows will reference it's content from the data source
                                // it will read it as dataScope.parentName, so in this case will read as "slides.slides_listing"
                                // in the dataProvider php file make sure to add ['slides']['slides_listing'] that contains the slide data. 
                                // see Prymag\BannerSlider\Ui\DataProvider\BannerDataProvider::getData() commented code dummy on how to add/format the data
                                // Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related is using "data.links" instead of direct reference, tried it here but not working. Why????
                                'dataScope' => 'slides', // 
                                'deleteButtonLabel' => __('Remove'),
                                // the field in the datasource where the insertListing component is adding it's content
                                // check the dataSource for more info. banner_form.banner_form_data_source
                                'dataProvider' => 'data.slides_listing',
                                'map' => [
                                    'id' => 'slide_id',
                                    'title' => 'title',
                                ],
                                'links' => [
                                    'insertData' => '${ $.provider }:${ $.dataProvider }'
                                ],                                
                            ]
                        ]
                    ],
                    'children' => [
                        'record' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => 'container',
                                        'isTemplate' => true,
                                        'is_collection' => true,
                                        'component' => 'Magento_Ui/js/dynamic-rows/record',
                                        'dataScope' => ''
                                    ],
                                ],
                            ],
                            'children' => $this->fillMeta(),
                        ]
                    ]
                ]
            ]
        ];
        
        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    protected function fillMeta()
    {
        return [
            'id' => $this->getTextColumn('id', false, __('ID'), 0),
            'title' => $this->getTextColumn('title', false, __('Title'), 20),
            'actionDelete' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'additionalClasses' => 'data-grid-actions-cell',
                            'componentType' => 'actionDelete',
                            'dataType' => Text::NAME,
                            'label' => __('Actions'),
                            'sortOrder' => 70,
                            'fit' => true,
                        ],
                    ],
                ],
            ],
            'position' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'dataType' => Number::NAME,
                            'formElement' => Input::NAME,
                            'componentType' => Field::NAME,
                            'dataScope' => 'position',
                            'sortOrder' => 80,
                            'visible' => false,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Retrieve text column structure
     *
     * @param string $dataScope
     * @param bool $fit
     * @param Phrase $label
     * @param int $sortOrder
     * @return array
     * @since 101.0.0
     */
    protected function getTextColumn($dataScope, $fit, Phrase $label, $sortOrder)
    {
        $column = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Field::NAME,
                        'formElement' => Input::NAME,
                        'elementTmpl' => 'ui/dynamic-rows/cells/text',
                        'component' => 'Magento_Ui/js/form/element/text',
                        'dataType' => Text::NAME,
                        'dataScope' => $dataScope,
                        'fit' => $fit,
                        'label' => $label,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];

        return $column;
    }

    public function dummy(){
        [
            'id' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => Field::NAME,
                            'formElement' => 'input',
                            'elementTmpl' => 'ui/dynamic-rows/cells/text',
                            'component' => 'Magento_Ui/js/form/element/text',
                            'dataType' => 'text',
                            'dataScope' => 'id',
                            'fit' => 'false',
                            'label' => 'ID',
                            'sortOrder' => '10',
                        ],
                    ],
                ],
            ],
            'title' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => Field::NAME,
                            'formElement' => 'input',
                            'elementTmpl' => 'ui/dynamic-rows/cells/text',
                            'component' => 'Magento_Ui/js/form/element/text',
                            'dataType' => 'text',
                            'dataScope' => 'title', // update
                            'fit' => 'false',
                            'label' => 'Title',
                            'sortOrder' => '20',
                        ],
                    ],
                ],
            ],
            
        ];
    }
}