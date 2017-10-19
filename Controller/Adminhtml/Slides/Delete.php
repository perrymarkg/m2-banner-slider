<?php

namespace Prymag\BannerSlider\Controller\Adminhtml\Slides;

class Delete extends \Magento\Backend\App\Action {

    public function execute()
    {
        $id = $this->getRequest()->getParam('slide_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Prymag\BannerSlider\Model\Slides');
                $model->load($id);
                
                // TODO: delete actual image
                // $image = $model->getImage();

                $model->delete();
                $this->messageManager->addSuccess(__('The slide has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['slide_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a post to delete.'));
        return $resultRedirect->setPath('*/*/');
    }

}