<?php

namespace Mageplaza\HelloWorld\Block;

class Menu extends \Magento\Framework\View\Element\Template
{
    protected $_template = "menu.phtml";
    protected $_postFactory;
    protected $categoryCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Mageplaza\HelloWorld\Model\PostFactory $postFactory,
        \Magento\Catalog\Model\ResourceModel\Category\Collection $categoryCollection
    ) {
        $this->_postFactory = $postFactory;
        $this->categoryCollection = $categoryCollection;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }

    public function getPostCollection()
    {
        $post = $this->_postFactory->create();
        return $post->getCollection();
    }

    public function getCategories()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categories = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\Collection');
        $categories->addAttributeToSelect('*')->addAttributeToSelect('*')->addAttributeToFilter('is_active', ['eq' => 1])->addAttributeToFilter('parent_id', ['eq' => 2]);
        $categories = $categories->toArray();
        function getCategories($categories)
        {
            foreach ($categories as $key => $value) {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $children = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\Collection');
                $children->addAttributeToSelect('*')->addAttributeToSelect('*')->addAttributeToFilter('is_active', ['eq' => 1])->addAttributeToFilter('parent_id', ['eq' => $value['entity_id']]);
                $children = $children->toArray();
                $children = getCategories($children);
                $categories[$key]['children'] = $children;
            }
            return $categories;
        }

        $categories = getCategories($categories);
        return $categories;
    }
}
