<?php

namespace Robin\Bai1\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Robin\Bai1\Model\BannerFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    protected $bannerFactory;

    public function __construct(Context $context, BannerFactory $bannerFactory)
    {
        // $this->pageFactory = $pageFactory;
        parent::__construct($context);
        $this->bannerFactory =  $bannerFactory;
    }

    public function execute()
    {
        // return $this->pageFactory->create();

        // $banner = $this->_objectManager->create('Robin\Bai1\Model\Banner');
        // // $banner->addData([
        // //     'link' => 'banner link',
        // //     'image' => 'avatar.png',
        // //     'sort_order' => 1,
        // //     'status' => true,
        // // ])->save();

        // $banner->load(1)->getData();

        // $banner->setImage("logo.png")->save();

        $banner = $this->bannerFactory->create();
        $collection = $banner->getCollection();
        // $data = $collection->getData();
        $query = $collection->addFieldToSelect(['id', 'image'])->addFieldToFilter('id', ['eq' => 1])->getData();
        dump($query);
        echo ('done');
    }
}
