<?php
namespace Noon\HideDefaultStoreCode\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_HIDE_DEFAULT_STORE_CODE = 'web/url/hide_default_store_code';

    /**
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

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

