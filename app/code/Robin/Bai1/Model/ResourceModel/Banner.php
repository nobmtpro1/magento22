<?php

namespace Robin\Bai1\Model\ResourceModel;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('banner', 'id');
    }

    protected function _afterSave(AbstractModel $object)
    {
        $image = $object->getData('image');
        if ($image) {
            $imageUploader = ObjectManager::getInstance()->get('Robin\Bai1\BannerImageUpload');
            $imageUploader->moveFileFromTmp($image);
        }
        return $this;
    }
}
