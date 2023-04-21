<?php

namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Robin\Bai1\Model\Banner;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Robin_Bai1::save';
    protected $dataProcessor;
    protected $dataPersistor;
    private $bannerFactory;
    private $bannerRepository;

    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        \Robin\Bai1\Model\BannerFactory $bannerFactory = null,
        \Magento\Cms\Api\PageRepositoryInterface $bannerRepository = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->bannerFactory = $bannerFactory ?: ObjectManager::getInstance()->get(\Robin\Bai1\Model\BannerFactory::class);
        $this->bannerRepository = $bannerRepository
            ?: ObjectManager::getInstance()->get(\Magento\Cms\Api\PageRepositoryInterface::class);
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            }

            if (isset($data['status']) && $data['status'] == 1) {
                $data['status'] = Banner::STATUS_ENABLED;
            } else {
                $data['status'] = Banner::STATUS_DISABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $model = $this->bannerFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->bannerRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the banner.'));
                $this->dataPersistor->clear('banner');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('banner', $data);
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
