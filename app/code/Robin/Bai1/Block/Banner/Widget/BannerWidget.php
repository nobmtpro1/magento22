<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Robin\Bai1\Block\Banner\Widget;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

/**
 * New products widget
 */
class BannerWidget extends Template implements \Magento\Widget\Block\BlockInterface
{
    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Robin\Bai1\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->setTemplate('widget.phtml');
        parent::__construct(
            $context,
            $data
        );
    }

    protected function _beforeToHtml()
    {
        $collection = $this->bannerCollectionFactory->create();
        $banners = $collection->addFieldToFilter('status', ['eq' => true])->getData();
        $this->setData('banners', $banners);
        $this->setData('mediaURL', $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'banner/images/');

        return parent::_beforeToHtml();
    }
}
