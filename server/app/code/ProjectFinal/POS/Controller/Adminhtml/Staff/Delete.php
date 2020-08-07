<?php


namespace ProjectFinal\POS\Controller\Adminhtml\Staff;


use Magento\Framework\App\ResponseInterface;
use ProjectFinal\POS\Controller\Adminhtml\Staff;

class Delete extends Staff
{

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $staffId = (int)$this->getRequest()->getParam("id");

        if ($staffId > 0) {
            $staffModel = $this->_objectManager->create('ProjectFinal\POS\Model\Staff')->load($staffId);

            try {
                $staffModel->delete();
                $this->messageManager->addSuccessMessage(__("Staff was successfully deleted"));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
            }
        }
        return $resultRedirect->setPath("*/*/");
    }
}
