<?php

/**
 * LowLevelApiHelper
 *
 * @file LowLevelApiHelper.php
 * @author Consid AB <henrik.soderlind@consid.se>
 * @created 2016-mar-23
 */

namespace Santander\Easycontract\Helper;

use Santander\Easycontract\LowLevelAPI\App;
use Santander\Easycontract\LowLevelAPI\Base\APIConnectorInterface;
use Santander\Easycontract\LowLevelAPI\Base\Config;
use Santander\Easycontract\Model\MonthlyInstalment;

class LowLevelApiHelper implements APIConnectorInterface
{
    /**
     *
     * @var \Santander\Easycontract\LowLevelAPI\App
     */
    public $api;
    
    /**
     *
     * @var \Santander\Easycontract\LowLevelAPI\Base\Logger 
     */
    public $logger;
    
    /**
     *
     * @var \Magento\Store\Api\Data\StoreInterface 
     */
    protected $_store;
    
    /**
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /**
     *
     * @var \Magento\FrameworkEncryption\EncryptorInterface 
     */
    protected $_encryptor;
    
    /**
     *
     * @var \Magento\Framework\Url 
     */
    protected $_url;
    
    /*public function __construct(
        \Magento\Store\Api\Data\StoreInterface $store,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\FrameworkEncryption\EncryptorInterface $encryptor
    ) 
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_store = $store;
        $this->_encryptor = $encryptor;
        
        if (!App::isRunning()) {
            App::run($this);
            $this->api = App::$api;
            $this->logger = App::$logger;
        }
    }*/
    public function __construct() {
        $this->_scopeConfig = \Magento\Framework\App\ObjectManager::getInstance()->get('\Magento\Framework\App\Config\ScopeConfigInterface');
        $this->_store = \Magento\Framework\App\ObjectManager::getInstance()->get('\Magento\Store\Api\Data\StoreInterface');
        $this->_encryptor = \Magento\Framework\App\ObjectManager::getInstance()->get('\Magento\Framework\Encryption\EncryptorInterface');
        $this->_url = \Magento\Framework\App\ObjectManager::getInstance()->get('\Magento\Framework\Url');
        
        if (!App::isRunning()) {
            App::run($this);
            $this->api = App::$api;
            $this->logger = App::$logger;
        }
    }
    
    protected function _getConfigData($field, $storeId = null)
    {
        if (null === $storeId) {
            $storeId = $this->_store->getId();
        }
        
        $path = 'payment/monthlyinstalment/' . $field;
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }
    
    public function getPlatformData($configKey)
    {
        switch ($configKey) {
            case Config::CONFIG_KEY_TEST_MODE:
                return $this->_getMode() == MonthlyInstalment::STATUS_TEST;
                break;
            case Config::CONFIG_KEY_SANDBOX_MODE:
                return $this->_getMode() == MonthlyInstalment::STATUS_TEST;
                break;
            case Config::CONFIG_KEY_STORE_ID:
                return $this->_getStoreId();
                break;
            case Config::CONFIG_KEY_USERNAME:
                return $this->_getUsername();
                break;
            case Config::CONFIG_KEY_PASSWORD:
                return $this->_getPassword();
                break;
            case Config::CONFIG_KEY_CERTIFICATE:
                return $this->_getCertificate();
                break;
            case Config::CONFIG_KEY_MERCHANT_ID:
                return $this->_getMerchantId();
                break;
            case Config::CONFIG_KEY_LANGUAGE:
                return $this->_getLanguage();
                break;
            case Config::CONFIG_KEY_SITE_EMAIL_ADDRESS:
                return $this->_getSiteMail();
                break;
            case Config::CONFIG_KEY_SITE_NAME:
                return $this->_getSiteName();
                break;
            case Config::CONFIG_KEY_PLATFORM_NAME:
                return $this->_getPlatformName();
                break;
            case Config::CONFIG_KEY_PLATFORM_VERSION:
                return $this->_getPlatformVersion();
                break;
            case Config::CONFIG_KEY_MODULE_VERSION:
                return $this->_getModuleVersion();
                break;
            case Config::CONFIG_KEY_MODULE_INSTALLATION_DATE:
                return $this->_getModuleInstallationDate();
                break;
            case Config::CONFIG_KEY_ENABLE_EXTENDED_LOGGING:
                return $this->_enableExtendedLogging();
                break;
            case Config::CONFIG_KEY_RETURN_URL:
                return $this->_getReturnUrl();
                break;
            case Config::CONFIG_KEY_ACCESS_LOG_EXTERNAL:
                return $this->_getAccessLogExternal();
                break;
        }
    }
    
    private function _getMode()
    {
        return $this->_getConfigData('env_test') == 1 ? MonthlyInstalment::STATUS_TEST : MonthlyInstalment::STATUS_PRODUCTION;
    }
    
    private function _getStoreId()
    {
        return $this->_getConfigData('store_id');
    }
    
    private function _getUsername()
    {
        return $this->_getConfigData('username');
    }
    
    private function _getPassword()
    {
        return $this->_getConfigData('password');
    }
    
    private function _getCertificate()
    {
        return;
    }
    
    private function _getMerchantId()
    {
        return $this->_getConfigData('merchant_id');
    }
    
    private function _getLanguage()
    {
        return 'en';
    }
    
    private function _getSiteMail()
    {
        return '';
    }
    
    private function _getSiteName()
    {
        /*return $this->_scopeConfig->getValue(
            'general/store_information/name', 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );*/
        return 'Santander Consumer Bank';
    }
    
    private function _getPlatformName()
    {
        return 'Magento';
    }
    
    private function _getPlatformVersion()
    {
        return \Magento\Framework\AppInterface::VERSION;
    }
    
    private function _getModuleVersion()
    {
        return '2.0.0';
    }
    
    private function _getModuleInstallationDate()
    {
        return;
    }
    
    private function _enableExtendedLogging()
    {
        return TRUE;
    }
    
    private function _getReturnUrl()
    {
        return $this->_url->getUrl('easycontract/monthlyinstalment/retur/');
    }
    
    private function _getAccessLogExternal()
    {
        return $this->_getConfigData('access_log_external');
    }
}

