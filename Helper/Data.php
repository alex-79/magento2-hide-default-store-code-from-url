<?php

namespace Noon\HideDefaultStoreCode\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_HIDE_DEFAULT_STORE_CODE = 'web/url/hide_default_store_code';

    /**
     *
     * @return boolean
     */
    public function isHideDefaultStoreCode()
    {
        if ($this->scopeConfig->getValue(self::XML_PATH_HIDE_DEFAULT_STORE_CODE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)) {
            return true;
        }
        return false;
    }
}
