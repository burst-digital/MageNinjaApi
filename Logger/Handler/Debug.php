<?php

namespace Burst\MageNinjaApi\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Debug extends Base {
  protected $fileName = '/var/log/MageNinjaApi/debug.log';
  protected $loggerType = Logger::DEBUG;
}