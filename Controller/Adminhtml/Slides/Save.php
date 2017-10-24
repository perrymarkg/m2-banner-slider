<?php

namespace Prymag\BannerSlider\Controller\Adminhtml\Slides;

class Save extends \Magento\Backend\App\Action {

    protected $dataPersistor;

    protected $resultPageFactory;

    protected $imageUploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Prymag\BannerSlider\Model\Image\ImageUploader $imageUploader,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }
    /**
     * following save function of Magento\Cms\Controller\Adminhtml\Block\Save
     *
     * @return void
     */
    public function execute(){
        
        $resultRedirect = $this->resultRedirectFactory->create();
        
        $data = $this->getRequest()->getPostValue();
        
        if ($data) {

            // Check and load the data if slide_id param exists, will be true if we are editing a slide
            $id = $this->getRequest()->getParam('slide_id');

            /**
             *  Load slide model using objectmanager instead of thru constructor or di. 
             *  display error message if entry does not exist anymore in the database.
             *  may be true when editing a slide
             */
            $model = $this->_objectManager->create('Prymag\BannerSlider\Model\Slides')->load($id);
            if (!$model->getSlideId() && $id) {
                $this->messageManager->addError(__('This slide no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            // move the file from tmp dir to main bannerslider dir
            if( isset($data['image']) && is_array($data['image'])){
                $data['image'] = $this->processImage($data['image']);
                // Maybe add a process to delete unused images in the future. m2 doesn't seem to do this at the moment.
                // for reference: in admin go to category, add featured image to any category. check pub/media/catalog/category. - images remain here even if changed in admin.
            }
                
            
            $model->setData($data);

            try {
                
                $model->save();
                $this->messageManager->addSuccess(__('Slide saved successfuly.'));
                /**
                 * dataPersistor seems to functions as a session
                 * see Prymag\BannerSlider\Ui\DataProvider\SlideDataProvider
                 */
                $this->dataPersistor->clear('prymag_slide');  

                return $resultRedirect->setPath('*/*/edit', ['slide_id' => $model->getSlideId()]);
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the slide.'));
            }


        }

        return $resultRedirect->setPath('*/*/');
    }

    public function processImage( $image ){
        try {
            return $this->imageUploader->moveFileFromTmp( $image[0]['file']);
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the slide.'));
        }
    }

}