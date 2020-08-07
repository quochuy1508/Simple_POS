<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ProjectFinal\POS\Model;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;
use ProjectFinal\POS\Api\CartItemRepositoryInterface;

/**
 * Cart Item repository class for guest carts.
 */
class CartItemRepository implements CartItemRepositoryInterface
{
    /**
     * @var \Magento\Quote\Api\CartItemRepositoryInterface
     */
    protected $repository;

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * Constructs a read service object.
     *
     * @param \Magento\Quote\Api\CartItemRepositoryInterface $repository
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     */
    public function __construct(
        \Magento\Quote\Api\CartItemRepositoryInterface $repository,
        QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getList($cartId)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        $cartItemList = $this->repository->getList($quoteIdMask->getQuoteId());
        /** @var $item CartItemInterface */
        foreach ($cartItemList as $item) {
            $item->setQuoteId($quoteIdMask->getMaskedId());
        }
        return $cartItemList;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Magento\Quote\Api\Data\CartItemInterface $cartItem)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartItem->getQuoteId(), 'masked_id');
        $cartItem->setQuoteId($quoteIdMask->getQuoteId());
        return $this->repository->save($cartItem);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($cartId, $itemId)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->repository->deleteById($quoteIdMask->getQuoteId(), $itemId);
    }
}
