<?php


namespace ProjectFinal\POS\Controller\Adminhtml\Staff;


use Magento\Framework\App\ResponseInterface;
use ProjectFinal\POS\Controller\Adminhtml\Staff;

class Edit extends Staff
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create('ProjectFinal\POS\Model\Staff');
        $registryObject = $this->_objectManager->get('Magento\Framework\Registry');
        if ($id) {
            $model = $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__("This staff no longer not exists"));
                return $resultRedirect->setPath('staff/*/', ['_current' => true]);
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $registryObject->register('current_staff', $model);
        $resultPage = $this->_resultPageFactory->create();

        if (!$model->getId()) {
            $pageTitle = __("NEW STAFF");
        } else {
            $pageTitle = __("EDIT STAFF ". $model->getName());
        }

        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
    }
}
