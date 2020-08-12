<?php


namespace ProjectFinal\POS\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Api\ShippingInformationManagementInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\GuestPaymentMethodManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteIdMaskFactory;
use ProjectFinal\POS\Api\OrderPOSManagementInterface;

/**
 * Class OrderPOSManagement to place order in POS web
 *
 * Class OrderPOSManagement
 */
class OrderPOSManagement implements OrderPOSManagementInterface
{

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var ShippingInformationManagementInterface
     */
    protected $shippingInformationManagement;

    /**
     * @var GuestPaymentMethodManagementInterface
     */
    protected $paymentMethodManagement;

    /**
     * @var GuestCartManagementInterface
     */
    protected $cartManagement;
    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param ShippingInformationManagementInterface $shippingInformationManagement
     * @param GuestPaymentMethodManagementInterface $paymentMethodManagement
     * @param GuestCartManagementInterface $cartManagement
     * @param CartRepositoryInterface $cartRepository
     * @codeCoverageIgnore
     */
    public function __construct(
        GuestPaymentMethodManagementInterface $paymentMethodManagement,
        GuestCartManagementInterface $cartManagement,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $cartRepository,
        ShippingInformationManagementInterface $shippingInformationManagement
    ) {
        $this->paymentMethodManagement = $paymentMethodManagement;
        $this->cartManagement = $cartManagement;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->cartRepository = $cartRepository;
        $this->shippingInformationManagement = $shippingInformationManagement;
    }
    /**
     * @inheritDoc
     */
    public function savePaymentInformationAndShippingInformation(
        $cartId,
        $email,
        PaymentInterface $paymentMethod,
        ShippingInformationInterface $addressInformation,
        AddressInterface $billingAddress = null
    ) {
        /** @var $quoteIdMask \Magento\Quote\Model\QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        $this->shippingInformationManagement->saveAddressInformation(
            $quoteIdMask->getQuoteId(),
            $addressInformation
        );

        $this->savePaymentInformation($cartId, $email, $paymentMethod, $billingAddress);
        try {
            $orderId = $this->cartManagement->placeOrder($cartId);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->getLogger()->critical(
                'Placing an order with quote_id ' . $cartId . ' is failed: ' . $e->getMessage()
            );
            throw new CouldNotSaveException(
                __($e->getMessage()),
                $e
            );
        } catch (\Exception $e) {
            $this->getLogger()->critical($e);
            throw new CouldNotSaveException(
                __('An error occurred on the server. Please try to place the order again.'),
                $e
            );
        }

        return $orderId;
    }

    /**
     * @inheritdoc
     */
    public function savePaymentInformation(
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        /** @var Quote $quote */
        $quote = $this->cartRepository->getActive($quoteIdMask->getQuoteId());

        if ($billingAddress) {
            $billingAddress->setEmail($email);
            $quote->removeAddress($quote->getBillingAddress()->getId());
            $quote->setBillingAddress($billingAddress);
            $quote->setDataChanges(true);
        } else {
            $quote->getBillingAddress()->setEmail($email);
        }

        $this->paymentMethodManagement->set($cartId, $paymentMethod);
        return true;
    }
}
