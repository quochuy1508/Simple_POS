<?php


namespace ProjectFinal\POS\Model\ResourceModel;

/**
 * Class Staff resource model
 */
class Staff extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('pos_staff', 'id');
    }
}
