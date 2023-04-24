<?php

namespace Mageplaza\HelloWorld\Block;

class Menu extends \Magento\Framework\View\Element\Template
{
    protected $_template = "menu.phtml";
    protected $categoryFactory;
    protected $urlRewrite;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\UrlRewrite\Model\UrlRewrite $urlRewrite,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->urlRewrite = $urlRewrite;
        parent::__construct($context);
    }

    public function getCategories()
    {
        $categoryFactory = $this->categoryFactory;
        $categories = $categoryFactory->create();
        $categories = $categories->addAttributeToSelect('*')->addAttributeToFilter('is_active', ['eq' => 1])->addAttributeToFilter('parent_id', ['eq' => 2])->setOrder('position', 'ASC');

        function getCategories($categories, $categoryFactory)
        {
            foreach ($categories as $value) {
                $children = $categoryFactory->create();
                $children = $children->addAttributeToSelect('*')->addAttributeToFilter('is_active', ['eq' => 1])->addAttributeToFilter('parent_id', ['eq' => $value->getData('entity_id')])->setOrder('position', 'ASC');
                $children = getCategories($children, $categoryFactory);
                $value->setData('children', $children);
            }
            return $categories;
        }

        $categories = getCategories($categories, $categoryFactory);
        return $categories;
    }

    public function getUrlRewrite($id)
    {
        return ($this->urlRewrite->getCollection()->addFieldToFilter('target_path', 'catalog/category/view/id/' . $id)->getFirstItem()->getData('request_path'));
    }
}
