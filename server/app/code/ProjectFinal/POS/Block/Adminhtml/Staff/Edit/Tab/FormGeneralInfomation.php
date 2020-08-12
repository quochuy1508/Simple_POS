<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

/**
 * Class FormGeneralInfomation manage info of username password
 */
class FormGeneralInfomation extends Generic implements TabInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     *
     * 44
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        $this->objectManager = $objectManager;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Method _prepareLayout
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock("page.title")->setPageTitle($this->getPageTitle());
    }

    /**
     * Method _prepareForm
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry("current_staff");
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix("page_");
        $fieldset = $form->addFieldset("base_fieldset", ["legend" => __("General Information")]);
        if ($model->getId()) {
            $fieldset->addField("id", "hidden", ["name" => "id"]);
        }
        $fieldset->addField("username", "text", [
            "label" => __("Username"),
            "class" => "required-entry",
            "required" => true,
            "name" => "username",
            "disabled" => false,
        ]);
        if ($model->getId()) {
            $fieldset->addField("password", "password", [
                "label" => __("Password"),
                "class" => "input-text",
                "name" => "password",
                "disabled" => false,
            ]);
            $fieldset->addField("password_confirmation", "password", [
                "label" => __("Password Confirmation"),
                "class" => "input-text",
                "name" => "password_confirmation",
                "disabled" => false,
            ]);
        } else {
            $fieldset->addField("password", "password", [
                "label" => __("Password"),
                "class" => "required-entry",
                "required" => true,
                "name" => "password",
                "disabled" => false,
            ]);
            $fieldset->addField("password_confirmation", "password", [
                "label" => __("Password Confirmation"),
                "class" => "required-entry",
                "required" => true,
                "name" => "password_confirmation",
                "disabled" => false,
            ]);
        }
        $fieldset->addField("status", "select", [
            "label" => __("Status"),
            "class" => "required-entry",
            "required" => true,
            "name" => "status",
            "options" => [
                0 => "Disabled",
                1 => "Enabled"
            ],
            "disabled" => false,
        ]);
        $model->setData("password_confirmation", $model->getPassword());
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Method getStaff
     *
     * @return mixed
     */
    public function getStaff()
    {
        return $this->_coreRegistry->registry("current_staff");
    }

    /**
     * Method getPageTitle
     *
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getstaff()->getId() ? __(
            'Edit Staff %1',
            $this->escapeHtml($this->getstaff()->getDisplayName())
        ) : __("New
            Staff");
    }

    /**
     * Method getTabLabel
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __("General Information");
    }

    /**
     * Method getTabTitle
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __("General Information");
    }

    /**
     * Method canShowTab
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Method isHidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
