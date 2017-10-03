<?php

namespace Prymag\BannerSlider\Controller\Adminhtml\Banners;

class Index extends \Magento\Backend\App\Action {
    
    protected $resultPageFactory;

    /**
    * Constructor
    *
    * @param \Magento\Backend\App\Action\Context $context
    * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
    */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
    * @return \Magento\Framework\View\Result\Page
    */
    public function execute(){

        return  $resultPage = $this->resultPageFactory->create();
    }

    public function getHeaderText()
    {
        return __('Banners');
    }

}