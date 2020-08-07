<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff\Edit;


class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            array(
                "data" => array(
                    "id" => "edit_form",
                    "action" => $this->getUrl("*/*/save", ["id" => $this->getRequest()->getParam("id")]),
                    "method" => "post",
                    "enctype" => "multipart/form-data"
                )
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
