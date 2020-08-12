<?php


namespace ProjectFinal\POS\Block\Adminhtml\Staff;

use Magento\Backend\Block\Widget\Form\Container;

/**
 * Class Edit to build frontend of header grid
 */
class Edit extends Container
{
    /**
     * @var \Magento\Framework\Registry|null
     */
    protected $coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Construct of class Edit
     */
    protected function _construct()
    {
        $this->_objectId = "id";
        $this->_blockGroup = "ProjectFinal_POS";
        $this->_controller = "adminhtml_staff";
        parent::_construct();
        $this->buttonList->update("save", "label", __("Save"));
        $this->buttonList->update("delete", "label", __("Delete"));
        $this->buttonList->add(
            "saveandcontinue",
            [
                "label" => __("Save and Continue Edit"),

                "class" => "save",
                "data_attribute" => [
                    "mage-init" => ["button" => ["event" => "saveAndContinueEdit",
                        "target" => "#edit_form"]]
                ]
            ],
            -100
        );
    }

    /**
     * Header of Grid Staff
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry("current_staff")->getId()) {
            return __(
                'Edit Staff "%1"',
                $this->escapeHtml($this->coreRegistry->registry("current_staff")->getData("name"))
            );
        } else {
            return __("New Staff");
        }
    }
}
