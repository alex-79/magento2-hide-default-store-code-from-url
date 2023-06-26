<?php

namespace Noon\HideDefaultStoreCode\Service;

class Config
{
    const XML_PATH_HIDE_DEFAULT_STORE_CODE = 'web/url/hide_default_store_code';
    const XML_PATH_REDIRECT_TO_URL_WITHOUT_STORE_CODE = 'web/url/redirect_to_url_without_store_code';

    const NO_REDIRECT = 0;
    const PERMANENT_REDIRECT = 301;
    const TEMPORARY_REDIRECT = 302;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    private function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function isHideDefaultStoreCode($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HIDE_DEFAULT_STORE_CODE, $storeId);
    }

    /**
     * @param null $storeId
     * @return int
     */
    public function getRedirectCode($storeId = null)
    {
        $code = $this->getConfigValue(self::XML_PATH_REDIRECT_TO_URL_WITHOUT_STORE_CODE, $storeId);

        if ($code == 301) {
            return self::PERMANENT_REDIRECT;
        }

        if ($code == 1) {
            return self::TEMPORARY_REDIRECT;
        }

        return self::NO_REDIRECT;
    }
}
