<?php

namespace Noon\HideDefaultStoreCode\Plugin\Model;

class HideDefaultStoreCode
{
    /**
     *
     * @var \Noon\HideDefaultStoreCode\Helper\Data
     */
    protected $helper;

    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     *
     * @param \Noon\HideDefaultStoreCode\Helper\Data $helper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Noon\HideDefaultStoreCode\Helper\Data $helper,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        $this->helper = $helper;
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
         if (
 			$this->helper->isHideDefaultStoreCode()
 			&& !is_null($defaultStore)
 		) {
             $url = str_replace('/'.$defaultStore->getCode().'/', '/', $url);
         }
         return $url;
     }
}
