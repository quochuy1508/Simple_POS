<?php


namespace ProjectFinal\POS\Api;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;

interface OrderPOSManagementInterface
{
    /**
     * Set payment information and place order for a specified cart.
     *
     * @param string $cartId
     * @param string $email
     * @param PaymentInterface $paymentMethod
     * @param ShippingInformationInterface $addressInformation
     * @param AddressInterface|null $billingAddress
     * @return int Order ID.
     * @throws CouldNotSaveException
     */
    public function savePaymentInformationAndShippingInformation(
        $cartId,
        $email,
        PaymentInterface $paymentMethod,
        ShippingInformationInterface $addressInformation,
        AddressInterface $billingAddress = null
    );

    /**
     * Set payment information for a specified cart.
     *
     * @param string $cartId
     * @param string $email
     * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
     * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return int Order ID.
     */
    public function savePaymentInformation(
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    );
}
