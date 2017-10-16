<?php

namespace Prymag\BannerSlider\Block\Adminhtml\Banners\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {
    
    protected $appDir;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('banner_form');
        $this->setTitle(__('Banner Form'));
    }

    /**
     * Build the form elements
     *
     * see \Magento\ImportExport\Block\Adminhtml\Import\Edit::_prepareForm();
     * 
     * @return void
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/savebanner'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );

        $fieldsets['base'] = $form->addFieldset('base_fieldset', ['legend' => __('Banner Information')]);
        
        
        $fieldsets['base']->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Banner Title'),
                'title' => __('Banner Title'),
                'required' => true
            ]
        );

        


        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    
}