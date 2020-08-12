<?php


namespace ProjectFinal\POS\Controller\Adminhtml\Staff;

use Magento\Framework\App\ResponseInterface;
use ProjectFinal\POS\Controller\Adminhtml\Staff;

/**
 * Class Edit to edit infomation of staff
 */
class Edit extends Staff
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Method execute to impliment of logic edit staff
     *
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create(\ProjectFinal\POS\Model\Staff::class);
        $registryObject = $this->_objectManager->get(\Magento\Framework\Registry::class);
        if ($id) {
            $model = $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__("This staff no longer not exists"));
                return $resultRedirect->setPath('staff/*/', ['_current' => true]);
            }
        }

        $data = $this->_objectManager->get(\Magento\Backend\Model\Session::class)->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $registryObject->register('current_staff', $model);
        $resultPage = $this->resultPageFactory->create();

        if (!$model->getId()) {
            $pageTitle = __("NEW STAFF");
        } else {
            $pageTitle = __("EDIT STAFF ". $model->getName());
        }

        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
    }
}
