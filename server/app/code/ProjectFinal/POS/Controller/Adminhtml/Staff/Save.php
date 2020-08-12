<?php


namespace ProjectFinal\POS\Controller\Adminhtml\Staff;

use ProjectFinal\POS\Controller\Adminhtml\Staff;

/**
 * Class Save save record staff
 */
class Save extends Staff
{

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
                $staffModel = $this->_objectManager->create(\ProjectFinal\POS\Model\Staff::class)->load($data["id"]);
                if (strlen($data["password"]) === 0) {
                    unset($data["password"]);
                }
            } else {
                $staffModel = $this->_objectManager->create(\ProjectFinal\POS\Model\Staff::class);
                if (strlen($data["password"]) === 0) {
                    $this->messageManager->addErrorMessage(__("Password require"));
                    return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
                }
            }

            $staffModel->setData($data);
            unset($staffModel["password_confirmation"]);
            unset($staffModel["form_key"]);
            try {
                $staffModel->save();

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
