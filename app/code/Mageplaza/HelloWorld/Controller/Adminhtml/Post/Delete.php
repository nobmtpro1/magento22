<?php

namespace Mageplaza\HelloWorld\Controller\Adminhtml\Post;

use Mageplaza\HelloWorld\Model\PostFactory;

class Delete extends \Magento\Backend\App\Action
{
    protected $postFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PostFactory $postFactory
    ) {
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        if ($this->getRequest()->isPost()) {
            try {
                $post = $this->postFactory->create();
                if ($id) {
                    $post = $post->load($id);
                    $post->delete();
                    $this->getMessageManager()->addSuccessMessage("You deleted.");
                }
            } catch (\Throwable $th) {
                $this->getMessageManager()->addErrorMessage($th->getMessage());
            }
        }

        return $this->_redirect('*/*/');
    }
}
