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
  const KEY_ID = 'id';

  /**
   * @return int
   */
  public function getId();

  /**
   * Sets the ID.
   *
   * @param int $id
   * @return $this
   */
  public function setId($id);
}