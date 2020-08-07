<?php


namespace ProjectFinal\POS\Model;


use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Api\PaymentInformationManagementInterface;
use Magento\Checkout\Api\ShippingInformationManagementInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\GuestBillingAddressManagementInterface;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\GuestPaymentMethodManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteIdMaskFactory;
use ProjectFinal\POS\Api\OrderPOSManagementInterface;

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
     * @var GuestBillingAddressManagementInterface
     */
    protected $billingAddressManagement;

    /**
     * @var GuestPaymentMethodManagementInterface
     */
    protected $paymentMethodManagement;

    /**
     * @var GuestCartManagementInterface
     */
    protected $cartManagement;

    /**
     * @var PaymentInformationManagementInterface
     */
    protected $paymentInformationManagement;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param ShippingInformationManagementInterface $shippingInformationManagement
     * @param GuestBillingAddressManagementInterface $billingAddressManagement
     * @param GuestPaymentMethodManagementInterface $paymentMethodManagement
     * @param GuestCartManagementInterface $cartManagement
     * @param PaymentInformationManagementInterface $paymentInformationManagement
     * @param CartRepositoryInterface $cartRepository
     * @codeCoverageIgnore
     */
    public function __construct(
        GuestBillingAddressManagementInterface $billingAddressManagement,
        GuestPaymentMethodManagementInterface $paymentMethodManagement,
        GuestCartManagementInterface $cartManagement,
        PaymentInformationManagementInterface $paymentInformationManagement,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $cartRepository,
        ShippingInformationManagementInterface $shippingInformationManagement
    ) {
        $this->billingAddressManagement = $billingAddressManagement;
        $this->paymentMethodManagement = $paymentMethodManagement;
        $this->cartManagement = $cartManagement;
        $this->paymentInformationManagement = $paymentInformationManagement;
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
//        var_dump($quoteIdMask->getData());
        $this->shippingInformationManagement->saveAddressInformation(
            $quoteIdMask->getQuoteId(),
            $addressInformation
        );

//        $this->
//        $method = $this->paymentInformationManagement->getPaymentInformation($quoteIdMask->getQuoteId())->getPaymentMethods()->getData();
//        var_dump($method);
//        die();
//
//        $this->paymentMethodManagement->set($quoteIdMask->getQuoteId(), $paymentMethod->getMethod());

        $this->savePaymentInformation($cartId, $email, $paymentMethod, $billingAddress);
//
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
//        $this->limitShippingCarrier($quote);

        $this->paymentMethodManagement->set($cartId, $paymentMethod);
        return true;
    }
}
