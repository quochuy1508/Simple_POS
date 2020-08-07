<?php


namespace ProjectFinal\POS\Model\ResourceModel;


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
