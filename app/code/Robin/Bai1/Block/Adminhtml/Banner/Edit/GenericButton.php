<?php

namespace Robin\Bai1\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;


class GenericButton
{
    protected $context;
    protected $bannerRepository;

    public function __construct(
        Context $context,
        PageRepositoryInterface $bannerRepository
    ) {
        $this->context = $context;
        $this->bannerRepository = $bannerRepository;
    }

    public function getPageId()
    {
        try {
            return $this->bannerRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
