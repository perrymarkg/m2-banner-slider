<?php

namespace Prymag\BannerSlider\Controller\Adminhtml\Banners;

class Edit extends \Magento\Backend\App\Action {

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute(){
        /*
        $banners = $this->bannersFactory->create();

        var_dump($banners->load(1)->getData());
        */
        return  $resultPage = $this->resultPageFactory->create();
    }
}