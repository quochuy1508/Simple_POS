<?php


namespace ProjectFinal\POS\Model;

use Magento\Framework\Controller\Result\JsonFactory;
use ProjectFinal\POS\Model\ResourceModel\Staff\CollectionFactory as StaffCollectionFactory;

class StaffManagement implements \ProjectFinal\POS\Api\StaffManagementInterface
{
    /**
     * @var StaffCollectionFactory
     */
    protected $staffCollectionFactory;

    /**
     * @param StaffCollectionFactory $staffCollectionFactory
     */
    public function __construct(
        StaffCollectionFactory $staffCollectionFactory
    )
    {
        $this->staffCollectionFactory = $staffCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function authenticate($username, $password)
    {

        try {
            $staff = $this->staffCollectionFactory->create()
                ->addFieldToSelect("*")
                ->addFieldToFilter("username", array("eq" => $username))
                ->getFirstItem();

            $staffId = (int)$staff->getId();
            if (!$staffId) {
                $massage = [[
                    "code" => "201",
                    "message" => "This account isn't confirmed. Verify and try again.",
                    "status" => false
                ]];
                return $massage;
            } else if ((int)$staff->getData("status") === 0) {
                $massage = array(array(
                    "code" => "401",
                    "message" => "This account isn't active. Please connect to admin of website",
                    "status" => false
                ));
                return $massage;
            } else if ($staff->getData("password") !== $password) {
                $massage = array(array(
                    "code" => "401",
                    "message" => "Password not correct. Please connect to admin of website",
                    "status" => false
                ));
                return $massage;
            }
            return [$staff->getData()];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
