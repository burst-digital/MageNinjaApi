<?php

namespace Burst\MageNinjaApi\Catalog\Api;

interface ProductRepositoryInterface {

  /**
   * Gets a list of all product IDs in the database.
   *
   * @return array
   *   All the product IDs
   */
  public function getAllIds();
}