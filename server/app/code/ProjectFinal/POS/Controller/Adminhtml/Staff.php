<?php


namespace ProjectFinal\POS\Controller\Adminhtml;


use Magento\Framework\App\ResponseInterface;

/**
 * Class Vendor
 * @package ProjectFinal\POS\Controller\Adminhtm
 */
abstract class Staff extends \Magento\Backend\App\Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }


    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ProjectFinal_POS::staff');
    }
}
