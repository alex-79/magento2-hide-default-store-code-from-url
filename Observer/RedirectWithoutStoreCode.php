<?php

namespace Noon\HideDefaultStoreCode\Observer;

class RedirectWithoutStoreCode implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $actionFlag;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Noon\HideDefaultStoreCode\Service\Config
     */
    protected $config;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Noon\HideDefaultStoreCode\Service\Config $config
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Noon\HideDefaultStoreCode\Service\Config $config,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->actionFlag = $actionFlag;
        $this->storeManager = $storeManager;
        $this->config = $config;
        $this->url = $url;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->config->isHideDefaultStoreCode() && $code = $this->config->getRedirectCode()) {
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $defaultStore = $this->storeManager->getWebsite($websiteId)->getDefaultStore();

            if (!is_null($defaultStore)) {
                $url = $this->url->getCurrentUrl();
                if ($this->isUrlWithDefaultCode($url, $defaultStore->getCode())) {
                    $controller = $observer->getData('controller_action');
                    $url = str_replace('/' . $defaultStore->getCode() . '/', '/', $url);
                    $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                    $controller->getResponse()->setRedirect($url, $code);
                }
            }
        }
    }

    /**
     * @param string $url
     * @param string $defaultCode
     * @return bool
     */
    private function isUrlWithDefaultCode($url, $defaultCode)
    {
        $urlParts = parse_url($url);
        if (isset($urlParts['path'])) {
            $pathParts = explode('/', ltrim($urlParts['path'], '/'), 2);
            if (isset($pathParts[0]) && $pathParts[0] == $defaultCode) {
                return true;
            }
        }
        return false;
    }
}
