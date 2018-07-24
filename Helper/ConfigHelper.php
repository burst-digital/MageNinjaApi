<?php

namespace Burst\MageNinjaApi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class ConfigHelper extends AbstractHelper
{
  const TAB_MAGENINJA = 'mageninja';

  const SECTION_CONFIGURATION = 'configuration';

  const GROUP_SYNCRHONISATION = 'synchronisation';

  const FIELD_URL = 'url';
  const FIELD_PUSH = 'push';
  const FIELD_DELETE = 'delete';

  public function get($field, $group, $section, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
  {
    return $this->scopeConfig->getValue(
      $section . '/' . $group . '/' . $field,
      $scopeType,
      $scopeCode
    );
  }

  public function getByPath($path, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
  {
    return $this->scopeConfig->getValue(
      $path,
      $scopeType,
      $scopeCode
    );
  }

}
