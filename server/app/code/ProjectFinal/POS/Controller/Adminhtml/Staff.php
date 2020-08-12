<?php


namespace ProjectFinal\POS\Controller\Adminhtml;

/**
 * Abstract class Staff
 */
abstract class Staff extends \Magento\Backend\App\Action
{

    /**
     * Allow to anonymous assess to resource
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ProjectFinal_POS::staff');
    }
}
