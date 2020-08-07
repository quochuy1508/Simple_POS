<?php


namespace ProjectFinal\POS\Controller\Adminhtml\Staff;

use ProjectFinal\POS\Controller\Adminhtml\Staff;

class Save extends Staff
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data["password_confirmation"] !== $data["password"]) {
            $this->messageManager->addErrorMessage(__("Password confirm not same with password"));
            return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
        }

        if ($data) {
            if (array_key_exists("id", $data)) {
                $staff_model = $this->_objectManager->create("ProjectFinal\POS\Model\Staff")->load($data["id"]);
                if (strlen($data["password"]) === 0) {
                    unset($data["password"]);
                }
            } else {
                $staff_model = $this->_objectManager->create("ProjectFinal\POS\Model\Staff");
                if (strlen($data["password"]) === 0) {
                    $this->messageManager->addErrorMessage(__("Password require"));
                    return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
                }
            }

            $staff_model->setData($data);
            unset($staff_model["password_confirmation"]);
            unset($staff_model["form_key"]);
            try {
                $staff_model->save();

                $this->messageManager->addSuccessMessage(__("Staff was successfully save"));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
            }

            if ($this->getRequest()->getParam("back") === 'edit') {
                return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
            }
            return $resultRedirect->setPath("*/*/");

        }
    }
}
