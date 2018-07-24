<?php

namespace Burst\MageNinjaApi\Observer;

use Burst\MageNinjaApi\Helper\ConfigHelper;
use Burst\MageNinjaApi\Logger\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\WebsiteManagementInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Website;
use Magento\Store\Model\WebsiteManagement;

class ProductSaveAfterObserver implements ObserverInterface {
  /** @var \Burst\MageNinjaApi\Logger\Logger */
  protected $logger;

  /** @var \Burst\MageNinjaApi\Helper\ConfigHelper */
  protected $configHelper;

  /** @var \Magento\Framework\Message\ManagerInterface */
  protected $messageManager;

  /** @var \Magento\Store\Api\WebsiteRepositoryInterface */
  protected $websiteRepository;

  /**
   * ProductSaveAfterObserver constructor.
   *
   * @param \Burst\MageNinjaApi\Logger\Logger $logger
   * @param \Burst\MageNinjaApi\Helper\ConfigHelper $configHelper
   * @param \Magento\Framework\Message\ManagerInterface $messageManager
   * @param \Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository
   */
  public function __construct(
    Logger $logger,
    ConfigHelper $configHelper,
    \Magento\Framework\Message\ManagerInterface $messageManager,
    \Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository
  )
  {
    $this->logger = $logger;
    $this->configHelper = $configHelper;
    $this->messageManager = $messageManager;
    $this->websiteRepository = $websiteRepository;
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
    
    $websiteIds = $_product->getWebsiteIds();
    if (count($websiteIds) > 1) {
      $this->messageManager->addErrorMessage('Could not push product to Drupal. Product must not be assigned to more than one website.');
      return;
    }

    $this->logger->debug('websites: ' . print_r($websiteIds, true));

    if (count($websiteIds) < 1) {
      $this->messageManager->addErrorMessage('Could not push product to Drupal. Product is not assigned to a website.');
      return;
    }

    try {
      $website = $this->websiteRepository->getById(array_keys($websiteIds)[0]);
    } catch (NoSuchEntityException $e) {
      $this->logger->error($e);
      $this->messageManager->addErrorMessage('Could not push product to Drupal. Check error log for more information.');
      return;
    }

    $url = $this->configHelper->get(
      ConfigHelper::FIELD_URL,
      ConfigHelper::GROUP_SYNCRHONISATION,
      ConfigHelper::SECTION_CONFIGURATION,
      ScopeInterface::SCOPE_WEBSITE,
      $website->getCode()
    );

    $this->logger->debug('Observer updating product ' . $_product->getId() . ' in Drupal.');

    $client = new Client();
    $response = $client->put($url . '/mage_ninja/product/' . $_product->getId(), [
      RequestOptions::JSON => $_product->toArray()
    ]);

    if ($response->getStatusCode() === \Zend\Http\Response::STATUS_CODE_200) {
      $this->messageManager->addSuccessMessage('Product data successfully pushed to Drupal.');
    }

  }
}
