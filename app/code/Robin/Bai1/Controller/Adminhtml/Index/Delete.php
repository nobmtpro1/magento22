<?php

namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;


class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Robin_Bai1::delete';
    protected $dataProcessor;
    protected $dataPersistor;
    private $bannerFactory;

    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        \Robin\Bai1\Model\BannerFactory $bannerFactory = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->bannerFactory = $bannerFactory ?: ObjectManager::getInstance()->get(\Robin\Bai1\Model\BannerFactory::class);
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->bannerFactory->create();

        if ($id) {
            try {
                $model = $model->load($id);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

        try {
            $model->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the banner.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getPrevious() ?: $e);
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while deleting the banner.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
