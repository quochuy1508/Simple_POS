<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff\Edit;


class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('staff_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__("Section"));
    }

    /**
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'general',
            [
                'label' => __('General Information'),
                'title' => __('general'),
                'content' => $this->getLayout()->createBlock('ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab\FormGeneralInfomation')
                    ->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'contact',
            [
                'label' => __('Contact'),
                'title' => __('contact-staff'),
                'content' => $this->getLayout()->createBlock('ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab\FormContact')
                    ->toHtml()
            ]
        );
        return parent::_beforeToHtml();
    }
}
