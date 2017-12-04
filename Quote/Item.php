<?php

namespace Burst\MageNinjaApi\Quote;

use Burst\MageNinjaApi\Quote\Api\Data\CartItemInterface;

class Item extends \Magento\Quote\Model\Quote\Item implements CartItemInterface {

  /**
   * {@inheritdoc}
   */
  public function getProductId()
  {
    return $this->getData(self::KEY_PRODCUCT_ID);
  }

  /**
   * {@inheritdoc}
   */
  public function setProductId($productId)
  {
    return $this->setData(self::KEY_PRODCUCT_ID, $productId);
  }
}