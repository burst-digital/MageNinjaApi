<?php

namespace Burst\MageNinjaApi\Catalog;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Burst\MageNinjaApi\Catalog\Api\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {

  /**
   * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
   */
  protected $_productCollectionFactory;

  /**
   * @var \Magento\Framework\App\ResourceConnection
   */
  protected $_resourceConnection;

  /**
   * ProductRepository constructor.
   *
   * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_productCollectionFactory
   * @param \Magento\Framework\App\ResourceConnection $_resourceConnection
   */
  public function __construct(CollectionFactory $_productCollectionFactory, ResourceConnection $_resourceConnection) {
    $this->_productCollectionFactory = $_productCollectionFactory;
    $this->_resourceConnection = $_resourceConnection;
  }

  /**
   * {@inheritdoc}
   */
  public function getAllIds() {
    $connection = $this->_resourceConnection->getConnection();
    $productEntityTable = $this->_resourceConnection->getTableName('catalog_product_entity');

    $select = $connection->select()
      ->from(
        ['product_entity' => $productEntityTable],
        ['entity_id']
      )->order(
        ['entity_id']
      );

    $productIds = $connection->fetchCol($select);

    return $productIds;
  }
}