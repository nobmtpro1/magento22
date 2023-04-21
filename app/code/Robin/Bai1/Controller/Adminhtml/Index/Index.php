<?php

namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Robin\Bai1\Model\BannerFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Robin_Bai1::banner_manager';
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Robin_Bai1::banner_manager');
        // $resultPage->addBreadcrumb(__('Dashboard'), __('Dashboard'));
        $resultPage->getConfig()->getTitle()->prepend(__('Banner manager'));

        return $resultPage;
    }
}
