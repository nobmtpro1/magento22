<?php

namespace Mageplaza\HelloWorld\Model;

use Mageplaza\HelloWorld\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $filterPool;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        FilterPool $filterPool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $blockCollectionFactory->create();
        $this->filterPool = $filterPool;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $post) {
            $post->setScope();
            $this->loadedData[$post->getId()] = $post->getData();
        }
        return $this->loadedData;
    }
}
