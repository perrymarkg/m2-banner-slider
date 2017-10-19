<?php

namespace Prymag\BannerSlider\Ui\DataProvider\Banners\Form\Modifiers;

use Magento\Framework\UrlInterface;
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
                    ]
                ]
            ],
            'children' => [
                'banner_slides_content' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'formElement' => 'container',
                                'componentType' => 'container',
                                'label' => false,
                                'template' => 'ui/form/components/complex',
                                'content' => 'Sample Content'
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
                                                            'targetName' => 'testTarget',
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
                                                'dataScope' => 'slides_grid',
                                                'externalProvider' => 'slides_grid.slide_data_source', // name of the datasource for the listing, 
                                                'selectionsProvider' => 'slides_grid.slide_data_source.prymag_slide_columns.ids', // the column id selection on the
                                                'ns' => 'slides_grid', // the namespace
                                                'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                                'realTimeLink' => true,
                                                'dataLinks' => [
                                                    'imports' => false,
                                                    'exports' => false
                                                ],
                                                'behaviourType' => 'simple',
                                                'externalFilterMode' => true,
                                                
                                            ]                                            
                                        ]
                                    ]
                                    
                                ]
                            ]
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
}