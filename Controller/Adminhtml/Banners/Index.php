<?php

namespace Prymag\BannerSlider\Controller\Adminhtml\Banners;

class Index extends \Magento\Backend\App\Action {
    
    protected $bannerFactory;

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Prymag\BannerSlider\Model\BannersFactory $bannersFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->bannersFactory = $bannersFactory;
    }

    /**
    * @return \Magento\Framework\View\Result\Page
    */
    public function execute(){
        /*
        $banners = $this->bannersFactory->create();

        var_dump($banners->load(1)->getData());
        */
        return  $resultPage = $this->resultPageFactory->create();
    }

    

}