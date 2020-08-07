<?php


namespace ProjectFinal\POS\Model\ResourceModel\Staff;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use ProjectFinal\POS\Model\Staff as Model;
use ProjectFinal\POS\Model\ResourceModel\Staff as ResourceModel;


class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
