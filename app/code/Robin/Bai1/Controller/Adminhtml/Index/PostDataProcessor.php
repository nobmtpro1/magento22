<?php

namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Cms\Model\Page\DomValidationState;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Config\Dom\ValidationSchemaException;

class PostDataProcessor
{
    protected $dateFilter;
    protected $validatorFactory;
    protected $messageManager;
    private $validationState;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory,
        DomValidationState $validationState = null
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
        $this->validationState = $validationState
            ?: ObjectManager::getInstance()->get(DomValidationState::class);
    }

    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'image' => __('Image'),
            'link' => __('Link'),
            'sort_order' => __('Sort order')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        if (!@$data['images'][0]['name']) {
            $errorNo = false;
            $this->messageManager->addErrorMessage(
                __('To apply changes you should fill in hidden required "%1" field', "image")
            );
        }
        return $errorNo;
    }

    private function validateData($data, $layoutXmlValidator)
    {
        try {
            if (!empty($data['layout_update_xml']) && !$layoutXmlValidator->isValid($data['layout_update_xml'])) {
                return false;
            }

            if (
                !empty($data['custom_layout_update_xml']) &&
                !$layoutXmlValidator->isValid($data['custom_layout_update_xml'])
            ) {
                return false;
            }
        } catch (ValidationException $e) {
            return false;
        } catch (ValidationSchemaException $e) {
            return false;
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e);
            return false;
        }

        return true;
    }
}
