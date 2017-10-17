<?php 

namespace Prymag\BannerSlider\Controller\Adminhtml\Slides;

class Index extends \Magento\Backend\App\Action {

    protected $collectionFactory;

    protected $resultPageFactory;
    
        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory,
            \Prymag\BannerSlider\Model\SlidesFactory $slidesFactory
        ) {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;
            $this->collectionFactory = $slidesFactory;
        }

        /**
    * @return \Magento\Framework\View\Result\Page
    */
    public function execute(){
        /* $slides = $this->collectionFactory->create();
        
        var_dump($slides->getCollection()->getData()); */
        return  $this->resultPageFactory->create();
    }

}