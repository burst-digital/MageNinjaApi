<?php

namespace Burst\MageNinjaApi\Product;

interface ProductRepositoryInterface {

  /**
   * Gets a list of all product IDs in the database.
   *
   * @return array
   *   All the product IDs
   */
  public function getAllIds();
}