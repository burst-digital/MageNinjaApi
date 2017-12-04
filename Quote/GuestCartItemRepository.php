<?php

namespace Burst\MageNinjaApi\Quote;

use Magento\Catalog\Model\ProductFactory;
use Magento\Quote\Api\CartItemRepositoryInterface;
use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Burst\MageNinjaApi\Quote\Api\GuestCartItemRepositoryInterface;

class GuestCartItemRepository extends \Magento\Quote\Model\GuestCart\GuestCartItemRepository implements GuestCartItemRepositoryInterface
{
  /**
   * @var \Magento\Quote\Api\CartItemRepositoryInterface
   */
  protected $repository;

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
    parent::__construct($repository, $quoteIdMaskFactory);

    $this->repository = $repository;
    $this->productFactory = $productFactory;
  }

  /**
   * List items that are assigned to a specified cart.
   *
   * @param string $cartId The cart ID.
   * @return \Burst\MageNinjaApi\Quote\Api\Data\CartItemInterface[] Array of items.
   * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
   */
  public function getList($cartId)
  {
    /** @var QuoteIdMask $quoteIdMask */
    $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');

    /** @var \Magento\Quote\Api\Data\CartItemInterface[] $cartItemList */
    $cartItemList = $this->repository->getList($quoteIdMask->getQuoteId());

    /** @var \Burst\MageNinjaApi\Quote\Api\Data\CartItemInterface[] $newCartItemList */
    $newCartItemList = [];

    foreach ($cartItemList as $item) {
      /** @var \Burst\MageNinjaApi\Quote\Item $item */

      $item->setQuoteId($quoteIdMask->getMaskedId());
      $product = $this->productFactory->create()->loadByAttribute('sku', $item->getSku());
      $item->setProductId($product->getId());

      array_push($newCartItemList, $item);
    }

    return $newCartItemList;
  }
}