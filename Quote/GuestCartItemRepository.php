<?php

namespace Burst\MageNinjaApi\Quote;

use Magento\Catalog\Model\ProductFactory;
use Magento\Quote\Api\CartItemRepositoryInterface;
use Burst\MageNinjaApi\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Burst\MageNinjaApi\Quote\Api\GuestCartItemRepositoryInterface;

class GuestCartItemRepository implements GuestCartItemRepositoryInterface
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
   * @var ProductFactory
   */
  protected $productFactory;

  /**
   * Constructs a read service object.
   *
   * @param \Magento\Quote\Api\CartItemRepositoryInterface $repository
   * @param QuoteIdMaskFactory $quoteIdMaskFactory
   * @param \Magento\Catalog\Model\ProductFactory $productFactory
   */
  public function __construct(
    CartItemRepositoryInterface $repository,
    QuoteIdMaskFactory $quoteIdMaskFactory,
    ProductFactory $productFactory
  ) {
    $this->quoteIdMaskFactory = $quoteIdMaskFactory;
    $this->repository = $repository;
    $this->productFactory = $productFactory;
  }

  /**
   * {@inheritdoc}
   */
  public function getList($cartId)
  {
    /** @var QuoteIdMask $quoteIdMask */
    $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
    $cartItemList = $this->repository->getList($quoteIdMask->getQuoteId());

    foreach ($cartItemList as $item) {
      /** @var CartItemInterface $item */

      $item->setQuoteId($quoteIdMask->getMaskedId());
      $product = $this->productFactory->create()->loadByAttribute('sku', $item->getSku());
//      $item->setId($product->getId());
      die($item->getItemId());
    }

    return $cartItemList;
  }
}