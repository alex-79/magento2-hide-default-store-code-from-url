<?php

namespace Noon\HideDefaultStoreCode\Plugin\Model;

class HideDefaultStoreCode
{
    /**
     *
     * @var \Noon\HideDefaultStoreCode\Service\Config
     */
    protected $config;

    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     *
     * @param \Noon\HideDefaultStoreCode\Service\Config $config
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Noon\HideDefaultStoreCode\Service\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    /**
     *
     * @param \Magento\Store\Model\Store $subject
     * @param string $url
     * @return string
     */
    public function afterGetBaseUrl(\Magento\Store\Model\Store $subject, $url)
    {
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $defaultStore = $this->storeManager->getWebsite($websiteId)->getDefaultStore();
        if ($this->config->isHideDefaultStoreCode() && !is_null($defaultStore)) {
            $url = str_replace('/' . $defaultStore->getCode() . '/', '/', $url);
        }
        return $url;
    }
}
