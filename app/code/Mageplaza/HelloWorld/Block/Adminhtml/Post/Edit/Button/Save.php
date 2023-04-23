<?php

namespace Mageplaza\HelloWorld\Block\Adminhtml\Post\Edit\Button;

use Magento\Ui\Component\Control\Container;

class Save extends Generic
{
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'class_name' => Container::DEFAULT_CONTROL,
        ];
    }
}
