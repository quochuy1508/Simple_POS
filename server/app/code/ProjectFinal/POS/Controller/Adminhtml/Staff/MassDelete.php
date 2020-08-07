<?php


namespace ProjectFinal\POS\Controller\Adminhtml\Staff;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use ProjectFinal\POS\Controller\Adminhtml\AbstractMassAction;
use ProjectFinal\POS\Controller\Adminhtml\Staff;
use ProjectFinal\POS\Model\ResourceModel\Staff\Collection;
use ProjectFinal\POS\Model\ResourceModel\Staff\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;

class MassDelete extends Staff
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectFinal_POS::staff';

    /**
     * @var string
     */
    protected $redirectUrl = '*/*/index';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    protected function massAction(Collection $collection)
    {
        var_dump($collection->getData());
        die();
        $count = 0;
        foreach ($collection as $staffModel) {
            $staffModel->delete();
            $count++;
        }
        $this->messageManager->addSuccessMessage('You have deleted %1 staff', $count);

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }

    protected function getComponentRefererUrl()
    {
        return "*/*/index";
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $item) {
                $item->delete();
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 element(s) have been deleted.', $collectionSize));

            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }
}
