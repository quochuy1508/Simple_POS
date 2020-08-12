<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff\Edit;

use ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab\FormContact;

/**
 * Class Tabs manage tab in grid backend
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * construct to build object Tabs
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('staff_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__("Section"));
    }

    /**
     * Method beforeToHtml
     *
     * @return \Magento\Backend\Block\Widget\Tabs|\Magento\Framework\View\Element\AbstractBlock
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
                'content' => $this->getLayout()->createBlock(
                    \ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab\FormGeneralInfomation::class
                )
                    ->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'contact',
            [
                'label' => __('Contact'),
                'title' => __('contact-staff'),
                'content' => $this->getLayout()->createBlock(FormContact::class)
                    ->toHtml()
            ]
        );
        return parent::_beforeToHtml();
    }
}
