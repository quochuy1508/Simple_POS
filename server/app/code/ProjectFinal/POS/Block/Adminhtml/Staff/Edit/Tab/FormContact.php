<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff\Edit\Tab;

/**
 * Class FormContact manage info of name telephone and email
 */
class FormContact extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
        $fieldset = $form->addFieldset("base_fieldset", ["legend" => __("Contact")]);
        if ($model->getId()) {
            $fieldset->addField("staff_id", "hidden", ["name" => "staff_id"]);
        }
        $fieldset->addField("name", "text", [
            "label" => __("Name"),

            "class" => "required-entry",
            "required" => true,
            "name" => "name",
            "disabled" => false,
        ]);
        $fieldset->addField("email", "text", [
            "label" => __("Email"),
            "class" => "input-text",
            "name" => "email",
            "disabled" => false,
        ]);
        $fieldset->addField("telephone", "text", [
            "label" => __("Phone"),
            "class" => "input-text",
            "name" => "telephone",
            "disabled" => false,
        ]);
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
        return $this->getstaff()->getId() ?
            __('Edit Staff %1', $this->escapeHtml($this->getstaff()->getDisplayName()))
            : __("New Staff");
    }

    /**
     * Method getTabLabel
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __("Contact");
    }

    /**
     * Method getTabTitle
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __("Contact");
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
