<?php

namespace Robin\Bai1\Model;


class Banner extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function _construct()
    {
        $this->_init('Robin\Bai1\Model\ResourceModel\Banner');
    }
}
