<?php

/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Robin\Bai1\Controller\Adminhtml\Index;

class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Robin_Bai1::save';
    protected $resultForwardFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // echo "new action";
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
