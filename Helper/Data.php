<?php

namespace Noon\HideDefaultStoreCode\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_HIDE_DEFAULT_STORE_CODE = 'web/url/hide_default_store_code';
    const XML_PATH_REDIRECT_TO_URL_WITHOUT_STORE_CODE = 'web/url/redirect_to_url_without_store_code';

    const NO_REDIRECT = 0;
    const PERMANENT_REDIRECT = 301;
    const TEMPORARY_REDIRECT = 302;

    /**
     * @return boolean
     */
    public function isHideDefaultStoreCode()
    {
        if ($this->scopeConfig->getValue(
            self::XML_PATH_HIDE_DEFAULT_STORE_CODE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getRedirectCode()
    {
        $code = $this->scopeConfig->getValue(
            self::XML_PATH_REDIRECT_TO_URL_WITHOUT_STORE_CODE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($code == 301) {
            return self::PERMANENT_REDIRECT;
        }

        if ($code == 1) {
            return self::TEMPORARY_REDIRECT;
        }

        return self::NO_REDIRECT;
    }
}
