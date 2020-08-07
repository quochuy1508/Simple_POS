<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab;


class FormGeneralInfomation extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

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
        array $data = array()
    )
    {
        $this->_objectManager = $objectManager;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock("page.title")->setPageTitle($this->getPageTitle());
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry("current_staff");
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix("page_");
        $fieldset = $form->addFieldset("base_fieldset", array("legend" => __("General Information")));
        if ($model->getId()) {
            $fieldset->addField("id", "hidden", array("name" => "id"));
        }
        $fieldset->addField("username", "text", array(
            "label" => __("Username"),
            "class" => "required-entry",
            "required" => true,
            "name" => "username",
            "disabled" => false,
        ));
        if ($model->getId()) {
            $fieldset->addField("password", "password", array(
                "label" => __("Password"),
                "class" => "input-text",
                "name" => "password",
                "disabled" => false,
            ));
            $fieldset->addField("password_confirmation", "password", array(
                "label" => __("Password Confirmation"),
                "class" => "input-text",
                "name" => "password_confirmation",
                "disabled" => false,
            ));
        } else {
            $fieldset->addField("password", "password", array(
                "label" => __("Password"),
                "class" => "required-entry",
                "required" => true,
                "name" => "password",
                "disabled" => false,
            ));
            $fieldset->addField("password_confirmation", "password", array(
                "label" => __("Password Confirmation"),
                "class" => "required-entry",
                "required" => true,
                "name" => "password_confirmation",
                "disabled" => false,
            ));
        }
        $fieldset->addField("status", "select", array(
            "label" => __("Status"),
            "class" => "required-entry",
            "required" => true,
            "name" => "status",
            "options" => array(
                0 => "Disabled",
                1 => "Enabled"
            ),
            "disabled" => false,
        ));
        $model->setData("password_confirmation", $model->getPassword());
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();

    }

    /**
     * @return mixed
     */
    public function getStaff()
    {
        return $this->_coreRegistry->registry("current_staff");
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getstaff()->getId() ? __('Edit Staff %1',
            $this->escapeHtml($this->getstaff()->getDisplayName())) : __("New
            Staff");
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __("General Information");
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __("General Information");
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
