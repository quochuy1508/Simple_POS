<?php


namespace ProjectFinal\POS\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface StaffManagementInterface
{
    /**#@+
     * Constant for confirmation status
     */
    const ACCOUNT_CONFIRMED = 'account_confirmed';
    const ACCOUNT_CONFIRMATION_REQUIRED = 'account_confirmation_required';
    const ACCOUNT_CONFIRMATION_NOT_REQUIRED = 'account_confirmation_not_required';
    const MAX_PASSWORD_LENGTH = 256;
    /**#@-*/

    /**
     * Authenticate a customer by username and password
     *
     * @param string $username
     * @param string $password
     * @return \ProjectFinal\POS\Api\Data\StaffInterface
     * @throws \Exception
     */
    public function authenticate($username, $password);

//    /**
//     * Validate customer data.
//     *
//     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
//     * @return \Magento\Customer\Api\Data\ValidationResultsInterface
//     * @throws \Magento\Framework\Exception\LocalizedException
//     */
//    public function validate(\Magento\Customer\Api\Data\CustomerInterface $customer);

}

