<?php

namespace Burst\MageNinjaApi\Observer;

use Burst\MageNinjaApi\Logger\Logger;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfterObserver implements ObserverInterface {
  /** @var \Burst\MageNinjaApi\Logger\Logger */
  protected $logger;

  /**
   * ProductSaveAfterObserver constructor.
   *
   * @param \Burst\MageNinjaApi\Logger\Logger $logger
   */
  public function __construct(
    Logger $logger
  )
  {
    $this->logger = $logger;
  }

  /**
   * @param Observer $observer
   *
   * @return void
   */
  public function execute(Observer $observer)
  {
    /** @var \Magento\Catalog\Model\Product $_product */
    $_product = $observer->getEvent()->getProduct();

    $this->logger->debug(print_r($_product->toArray(), true));
}}