<?php

namespace Burst\MageNinjaApi\Observer;

use Burst\MageNinjaApi\Logger\Logger;
use GuzzleHttp\Client;
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

    $this->logger->debug('Observer updating product ' . $_product->getId() . ' in Drupal.');

    $client = new Client();
    $result = $client->get('webserver.drupal/mage_ninja/import/' . $_product->getId());
    $this->logger->debug('Status code: ' . $result->getStatusCode());
    $this->logger->debug('Result: ' . $result->getBody());
}}