<?php

namespace Noon\HideDefaultStoreCode\Plugin\Model;

class HideDefaultStoreCode
{
    /**
     *
     * @var \Noon\HideDefaultStoreCode\Service\Config
     */
    private $config;

    /**
     * @param \Noon\HideDefaultStoreCode\Service\Config $config
     */
    public function __construct(
        \Noon\HideDefaultStoreCode\Service\Config $config
    ) {
        $this->config = $config;
    }

    /**
     *
     * @param \Magento\Store\Model\Store $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsUseStoreInUrl(\Magento\Store\Model\Store $subject, bool $result)
    {
        if ($this->config->isHideDefaultStoreCode() && $subject->getCode() !== \Magento\Store\Model\Store::ADMIN_CODE && $subject->isDefault()) {
            return false;
        }

        return $result;
    }
}
