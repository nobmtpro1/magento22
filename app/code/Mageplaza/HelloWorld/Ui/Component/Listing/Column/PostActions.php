<?php

namespace Mageplaza\HelloWorld\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;


class PostActions extends Column
{
    const SYNONYM_URL_PATH_DELETE = 'mageplaza_helloworld/post/delete';
    const SYNONYM_URL_PATH_EDIT = 'mageplaza_helloworld/post/edit';

    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                $item[$name]['delete'] = [
                    'href' => $this->urlBuilder->getUrl(
                        self::SYNONYM_URL_PATH_DELETE,
                        ['post_id' => $item['post_id']]
                    ),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete'),
                        'message' => __('Are you sure you want to delete', $item['post_id'])
                    ],
                    'post' => true,
                    '__disableTmpl' => true
                ];
                $item[$name]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(self::SYNONYM_URL_PATH_EDIT, ['post_id' => $item['post_id']]),
                    'label' => __('View/Edit'),
                    '__disableTmpl' => true
                ];
            }
        }

        return $dataSource;
    }
}
