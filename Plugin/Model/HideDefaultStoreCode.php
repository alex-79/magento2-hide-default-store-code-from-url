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
        if ($this->helper->isHideDefaultStoreCode() && !is_null($this->storeManager->getDefaultStoreView())) {
            $url = str_replace('/'.$this->storeManager->getDefaultStoreView()->getCode().'/', '/', $url);
        }
        return $url;
    }
}