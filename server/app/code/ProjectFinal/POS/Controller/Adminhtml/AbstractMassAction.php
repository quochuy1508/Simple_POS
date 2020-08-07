<?php


namespace ProjectFinal\POS\Controller\Adminhtml;


use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

use ProjectFinal\POS\Model\ResourceModel\Staff\CollectionFactory;
use ProjectFinal\POS\Model\ResourceModel\Staff\Collection;

abstract class AbstractMassAction extends \Magento\Backend\App\Action
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

    /**
     * @return $this
     */
    public function execute()
    {
//        echo "DA vao";
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            return $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ProjectFinal_POS::staff');
    }

    protected function getComponentRefererUrl()
    {
        return "*/*/index";
    }

    abstract protected function massAction(Collection $collection);
}
