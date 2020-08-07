<?php

namespace ProjectFinal\POS\Controller\Adminhtml\Staff;

use Magento\Framework\Controller\ResultFactory;
use ProjectFinal\POS\Controller\Adminhtml\Staff;

class NewAction extends Staff
{
    public function execute()
    {
        $resultFoward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultFoward->forward('edit');
    }
}
