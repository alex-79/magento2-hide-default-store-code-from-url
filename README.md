# HideDefaultStoreCode

Magento 2 plugin for hide *Default Store Code* from URL.

<https://bender.kr.ua/howto-hide-default-store-code-from-url-magento-2/>

![howto-hide-default-store-code-from-url-magento-2](https://bender.kr.ua/img/howto-hide-default-store-code-from-url-magento-2-1-1.png)

***

## Installation

### manual

1. Download ZIP file and extract to **app/code/Noon/HideDefaultStoreCode**. If this path not exists, please create under Magento2 root directory.
2. Run the command in Magento2 root directory:

```bash
php bin/magento setup:upgrade
```

### composer

```
composer config repositories.noon-hide-default-store-code git https://github.com/alex-79/magento2-hide-default-store-code-from-url.git
composer require noon/hide-default-store-code:dev-master
```

## Configuration

*Stores > Configuration > General > Web > Url Options > Hide Default Store Code*
