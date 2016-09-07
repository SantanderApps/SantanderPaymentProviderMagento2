<?php

/**
 * Config
 *
 * @file Config.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Base;

use Santander\Easycontract\LowLevelAPI\I18n\Market;
use Santander\Easycontract\LowLevelAPI\Soap\Country;

class Config {
    /**
     * The external/platform connector
     * @var APIConnectorInterface 
     */
    private $_connector;
    
    const WSDL_PROD = "https://integration.santanderconsumer.se/ofs.asmx?wsdl";
    const WSDL_TEST = "https://test.integration.santanderconsumer.se/ofs.asmx?wsdl";
    const WSDL_SANDBOX = 'https://webstub.santanderconsumer.se/webservice/ofs.asmx?wsdl';
    const SF_PROD = "https://sf.santanderconsumer.se/default.aspx?Token=";
    const SF_TEST = "https://sftest.santanderconsumer.se/default.aspx?Token=";
    const SF_SANDBOX = 'https://webstub.santanderconsumer.se/default.aspx?Token=';
    
    const CLIENT_SITE_URL = 'http://santander.consid.se/site/contact?store_id=';
    
    const CONFIG_KEY_TEST_MODE = 'test_mode';
    const CONFIG_KEY_SANDBOX_MODE = 'sandbox_mode';
    const CONFIG_KEY_STORE_ID = 'store_id';
    const CONFIG_KEY_USERNAME = 'ws_username';
    const CONFIG_KEY_PASSWORD = 'ws_password';
    const CONFIG_KEY_CERTIFICATE = 'ws_certificate';
    const CONFIG_KEY_MERCHANT_ID = 'merchant_id';
    const CONFIG_KEY_LANGUAGE = 'language';
    const CONFIG_KEY_MARKET = 'market';
    const CONFIG_KEY_PAYMENT_METHOD = 'payment_method';
    const CONFIG_KEY_SITE_EMAIL_ADDRESS = 'site_mail';
    const CONFIG_KEY_SITE_NAME = 'site_name';
    const CONFIG_KEY_PLATFORM_NAME = 'platform_name';
    const CONFIG_KEY_PLATFORM_VERSION = 'platform_version';
    const CONFIG_KEY_MODULE_VERSION = 'module_version';
    const CONFIG_KEY_MODULE_INSTALLATION_DATE = 'module_installation_date';
    const CONFIG_KEY_ENABLE_EXTENDED_LOGGING = 'enable_extended_logging';
    const CONFIG_KEY_RETURN_URL = 'return_url';
    const CONFIG_KEY_ACCESS_LOG_EXTERNAL = 'access_log_external';
    const CONFIG_KEY_LOG_DIRECTORY = 'log_directory';
    
    /**
     * 
     * @param \Santander\Easycontract\LowLevelAPI\Base\APIConnectorInterface $config the external/platform connector
     */
    public function __construct(APIConnectorInterface $connector) {
        $this->_connector = $connector;
    }
    
    /**
     * Return redirect url
     * @param string $token
     * @return string
     */
    public function getRedirectUrl($token) {
        if ($this->isSandboxMode()) {
            return static::SF_SANDBOX . $token;
        }
        else {
            return ($this->isTestMode() ? static::SF_TEST : static::SF_PROD) . $token;
        }
    }
    
    /**
     * Return the wsdl url
     * @return string
     */
    public function getWsdlUrl() {
        if ($this->isSandboxMode()) {
            return static::WSDL_SANDBOX;
        }
        else {
            return $this->isTestMode() ? static::WSDL_TEST : static::WSDL_PROD;
        }
    }
    
    /**
     * Checks whether API is in test mode
     * @return boolean
     */
    public function isTestMode() {
        return (bool)$this->_connector->getPlatformData(static::CONFIG_KEY_TEST_MODE);
    }
    
    /**
     * Checks whether API is in sandbox mode
     * @return boolean
     */
    public function isSandboxMode() {
        return (bool)$this->_connector->getPlatformData(static::CONFIG_KEY_SANDBOX_MODE);
    }
    
    /**
     * Return the store ID
     * @return integer
     */
    public function getStoreId() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_STORE_ID);
    }
    
    /**
     * Return the webservice username
     * @return string
     */
    public function getUsername() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_USERNAME);
    }
    
    /**
     * Return the webservice password
     * @return string
     */
    public function getPassword() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_PASSWORD);
    }
    
    /**
     * Return the webservice certificate
     * @return string
     */
    public function getCertificate() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_CERTIFICATE);
    }
    
    /**
     * Return the merchant ID
     * @return string|integer
     */
    public function getMerchantId() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_MERCHANT_ID);
    }
    
    /**
     * Return the language,
     * The returned language must be the language that the end user have selected
     * in the platform.
     * @return string
     */
    public function getLanguage() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_LANGUAGE);
    }
    
    /**
     * Return the market.
     * The returned value must be an instance of \Santander\Easycontract\LowLevelAPI\I18n\Market.
     * NOT YET IMPLEMENTED!
     * @ignore
     * @return \Santander\Easycontract\LowLevelAPI\I18n\Market
     */
    public function getMarket() {
        $market = new Market();
        $market->country = Country::SE;
        $market->currency = 'SEK';
        return $market;
    }
    
    /**
     * Return the selected payment method.
     * NOT YET IMPLEMENTED!
     * @return string
     */
    public function getPaymentMethod() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_PAYMENT_METHOD);
    }
    
    /**
     * Return e-mail address where the log file will be sent
     * @return string
     */
    public function getLogEmailAddress() {
        return 'santander@consid.se';
    }
    
    /**
     * Return the site e-mail address
     * @return string
     */
    public function getSiteEmailAddress() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_SITE_EMAIL_ADDRESS);
    }
    
    /**
     * Return the name of the site
     * @return string
     */
    public function getSiteName() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_SITE_NAME);
    }
    
    /**
     * Return the name of the platform (i.e. osCommerce, Magento, Woocommerce)
     * @return string
     */
    public function getPlatformName() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_PLATFORM_NAME);
    }
    
    /**
     * Return the version number of the platform.
     * @return string
     */
    public function getPlatformVersion() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_PLATFORM_VERSION);
    }
    
    /**
     * Return the version number of the current installed module.
     * @return string
     */
    public function getModuleVersion() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_MODULE_VERSION);
    }
    
    /**
     * Return the module installation date.
     * @return timestamp
     */
    public function getModuleInstallationDate() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_MODULE_INSTALLATION_DATE);
    }
    
    /**
     * Check if API should enable extended logging.
     * Enable extended logging enable i.e. traces of soap call.
     * @return bool
     */
    public function getEnableExtendedLogging() {
        return (bool)$this->_connector->getPlatformData(static::CONFIG_KEY_ENABLE_EXTENDED_LOGGING);
    }
    
    /**
     * Return the URL to the Santander Client Area site
     * @return string
     */
    public function getClientSiteUrl() {
        return static::CLIENT_SITE_URL . $this->getStoreId();
    }
    
    /**
     * Return the URL to the page the customer will return to from Santander´s 
     * website.
     */
    public function getReturnUrl() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_RETURN_URL);
    }
    
    /**
     * Check if log is accessable external
     * @return bool
     */
    public function getAccessLogExternal() {
        return (bool)$this->_connector->getPlatformData(static::CONFIG_KEY_ACCESS_LOG_EXTERNAL);
    }
    
    /**
     * Get path to where log files are saved
     * @return string
     */
    public function getLogDir() {
        return $this->_connector->getPlatformData(static::CONFIG_KEY_LOG_DIRECTORY);
    }
}
