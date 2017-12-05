<?php

namespace Burst\MageNinjaApi\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfterObserver implements ObserverInterface {

  /**
   * @param Observer $observer
   *
   * @return void
   */
  public function execute(Observer $observer)
  {
    /** @var \Magento\Catalog\Model\Product $_product */
    $_product = $observer->getEvent()->getProduct();
}}