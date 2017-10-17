<?php

namespace Prymag\BannerSlider\Ui\DataProvider\Banners\Form\Modifiers;

class AddSlides implements \Magento\Ui\DataProvider\Modifier\ModifierInterface {
    
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
                                    ]
                                ]
                            ],
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