<?php

namespace Mageplaza\HelloWorld\Controller\Adminhtml\Post;

class NewAction extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_forward('edit');
    }
}
