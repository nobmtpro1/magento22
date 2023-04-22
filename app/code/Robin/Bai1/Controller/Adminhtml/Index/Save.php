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
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->dataProcessor->validateRequireEntry($data)) {
            return $this->handleRedirect($resultRedirect, $id, $data);
        }

        if (isset($data['status']) && $data['status'] == 1) {
            $data['status'] = Banner::STATUS_ENABLED;
        } else {
            $data['status'] = Banner::STATUS_DISABLED;
        }
        $image = @$data['images'][0];
        $data['image'] = $image['name'];
        // dump($image);
        // exit;
        $model = $this->bannerFactory->create();

        if ($id) {
            try {
                $model = $model->load($id);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $this->handleRedirect($resultRedirect, $id, $data);
            }
        }

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('You saved the banner.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getPrevious() ?: $e);
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the banner.'));
        }

        return $this->handleRedirect($resultRedirect, $id);
    }

    public function handleRedirect($resultRedirect, $id, $data = null)
    {
        if ($id) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
        }
        if ($data) {
            $this->dataPersistor->set('banner', $data);
        }
        return $resultRedirect->setPath('*/*/new', ['_current' => true]);
    }
}
