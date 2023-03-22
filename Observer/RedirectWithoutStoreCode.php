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
     * @var \Noon\HideDefaultStoreCode\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     *
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Noon\HideDefaultStoreCode\Helper\Data $helper
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Noon\HideDefaultStoreCode\Helper\Data $helper,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->actionFlag = $actionFlag;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
        $this->url = $url;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $defaultStore = $this->storeManager->getWebsite($websiteId)->getDefaultStore();

        if (!is_null($defaultStore)) {
            $url = $this->url->getCurrentUrl();
            $pos = strpos($url, $this->storeManager->getStore()->getBaseUrl() . $defaultStore->getCode());

            if (
                $this->helper->isHideDefaultStoreCode() &&
                $pos !== false &&
                $code = $this->helper->getRedirectCode()
            ) {
                $controller = $observer->getData('controller_action');
                $url = str_replace('/' . $defaultStore->getCode() . '/', '/', $url);
                $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                $controller->getResponse()->setRedirect($url, $code);
            }
        }
    }
}
