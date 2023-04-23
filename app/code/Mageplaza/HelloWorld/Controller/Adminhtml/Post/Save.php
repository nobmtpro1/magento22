<?php

namespace Mageplaza\HelloWorld\Controller\Adminhtml\Post;

use Mageplaza\HelloWorld\Model\PostFactory;

class Save extends \Magento\Backend\App\Action
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
            $input = $this->getRequest()->getPostValue();
            $validate = $this->validate($input);
            if ($validate['error']) {
                $this->getMessageManager()->addErrorMessage($validate['messages']);
                $this->_getSession()->setFormData($input);
                return $this->redirect($id);
            }
            $post = $this->postFactory->create();

            if ($id) {
                $post = $post->load($id);
                $post->setData($input)->save();
            }
            $post->setData($input)->save();
            $this->getMessageManager()->addSuccessMessage("You saved the post.");
        }

        return $this->redirect($id);
    }

    public function validate($input)
    {
        $error = false;
        $messages = [];
        if (!@$input['name']) {
            $error = true;
            $messages[] = "Name is required";
        }
        if (!@$input['url_key']) {
            $error = true;
            $messages[] = "Url key is required";
        }
        return [
            'error' => $error,
            'messages' => implode(", ", $messages)
        ];
    }

    public function redirect($id)
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/new');
    }
}
