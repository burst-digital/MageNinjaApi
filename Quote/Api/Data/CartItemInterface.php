<?php

namespace Burst\MageNinjaApi\Quote\Api\Data;

/**
 * Interface CartItemInterface
 * @api
 */
interface CartItemInterface extends \Magento\Quote\Api\Data\CartItemInterface {
  /**
   * Constants defined for keys of array, makes typos less likely
   */
  const KEY_PRODCUCT_ID = 'product_id';

  /**
   * Returns the product ID.
   *
   * @return int
   */
  public function getProductId();

  /**
   * Sets the product ID.
   *
   * @param int $id
   * @return $this
   */
  public function setProductId($id);
}