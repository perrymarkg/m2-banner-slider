<?php 

namespace Prymag\BannerSlider\Controller\Adminhtml\Banners;

class Save extends \Magento\Backend\App\Action {

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute(){
        
        $resultRedirect = $this->resultRedirectFactory->create();
        
        $data = $this->getRequest()->getPostValue();
        /* var_dump($data);
        die(); */
        if ($data) {

            $id = $this->getRequest()->getParam('banner_id');
            $model = $this->_objectManager->create('Prymag\BannerSlider\Model\Banners')->load($id);

            if (!$model->getBannerId() && $id) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                
                $model->save();
                $this->messageManager->addSuccess(__('Banner saved successfuly.'));
                $this->dataPersistor->clear('prymag_banner');  

                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getBannerId()]);
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

}