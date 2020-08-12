<?php


namespace ProjectFinal\POS\Model;

use ProjectFinal\POS\Model\ResourceModel\Staff\CollectionFactory as StaffCollectionFactory;

/**
 * Class StaffManagement for staff authentication in React
 *
 */
class StaffManagement implements \ProjectFinal\POS\Api\StaffManagementInterface
{
    /**
     * @var StaffCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param StaffCollectionFactory $collectionFactory
     */
    public function __construct(
        StaffCollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function authenticate($username, $password)
    {

        try {
            $staff = $this->collectionFactory->create()
                ->addFieldToSelect("*")
                ->addFieldToFilter("username", ["eq" => $username])
                ->getFirstItem();

            $staffId = (int)$staff->getId();
            if (!$staffId) {
                $massage = [[
                    "code" => "201",
                    "message" => "This account isn't confirmed. Verify and try again.",
                    "status" => false
                ]];
                return $massage;
            } elseif ((int)$staff->getData("status") === 0) {
                $massage = [[
                    "code" => "401",
                    "message" => "This account isn't active. Please connect to admin of website",
                    "status" => false
                ]];
                return $massage;
            } elseif ($staff->getData("password") !== $password) {
                $massage = [[
                    "code" => "401",
                    "message" => "Password not correct. Please connect to admin of website",
                    "status" => false
                ]];
                return $massage;
            }
            return [$staff->getData()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
