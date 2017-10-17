<?php

namespace Prymag\BannerSlider\Controller\Adminhtml\Slides;

class Edit extends \Magento\Backend\App\Action {

    protected $_coreRegistry;

    protected $resultPageFactory;

    

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
    }

    public function execute(){
        
        $id = $this->getRequest()->getParam('slide_id');
        $model = $this->_objectManager->create(\Prymag\BannerSlider\Model\Slides::class);

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This slide no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('slide_test', $model); // what does this do??
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Prymag_BannerSlider::top_level');
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Slide'));
        
        return $resultPage;
    }
}