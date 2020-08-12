<?php

namespace ProjectFinal\POS\Controller\Adminhtml\Staff;

use Magento\Framework\Controller\ResultFactory;
use ProjectFinal\POS\Controller\Adminhtml\Staff;

/**
 * Class NewAction implement add new staff
 */
class NewAction extends Staff
{
    /**
     * Method to add new record
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultFoward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultFoward->forward('edit');
    }
}
