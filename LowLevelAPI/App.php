<?php

/**
 * App
 *
 * @file App.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-nov-27
 */

namespace Santander\Easycontract\LowLevelAPI;

defined('SANTANDER_BASE_PATH') or define('SANTANDER_BASE_PATH', realpath(__DIR__));
define('SANTANDER_LIB_PATH', SANTANDER_BASE_PATH . DIRECTORY_SEPARATOR . 'src');

use Santander\Easycontract\LowLevelAPI\Base\Config;
use Santander\Easycontract\LowLevelAPI\Base\Logger;
use Santander\Easycontract\LowLevelAPI\Soap\SoapClient;
use Santander\Easycontract\LowLevelAPI\Soap\SoapHeaders;
use Santander\Easycontract\LowLevelAPI\Soap\Authentication;
use Santander\Easycontract\LowLevelAPI\Soap\IdentificationType;
use Santander\Easycontract\LowLevelAPI\Soap\Identifier;
use Santander\Easycontract\LowLevelAPI\Soap\IdentifierType;
use Santander\Easycontract\LowLevelAPI\Soap\Identifiers;
use Santander\Easycontract\LowLevelAPI\Soap\Login;
use Santander\Easycontract\LowLevelAPI\Soap\TransactionHelper;
use Santander\Easycontract\LowLevelAPI\Soap\AuthorizationType;
use Santander\Easycontract\LowLevelAPI\Soap\Actions\GetTokenRequest;
use Santander\Easycontract\LowLevelAPI\Soap\Actions\GetToken;
use Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResultRequest;
use Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResult;
use Santander\Easycontract\LowLevelAPI\Model\Token;
use Santander\Easycontract\LowLevelAPI\Model\Result;
use Santander\Easycontract\LowLevelAPI\Model\Address;
use Santander\Easycontract\LowLevelAPI\I18n\Message;
use Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnectionRequest;
use Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnection;

/**
 * @property \Santander\Easycontract\LowLevelAPI\Base\Config $config
 * @property \Santander\Easycontract\LowLevelAPI\Base\Logger $logger
 * @property array $requirements the requirements for the API to work properly
 */
class App {
    /**
     * @var \Santander\Easycontract\LowLevelAPI\Base\Config 
     */
    protected $config;
    
    /**
     * @var self 
     */
    public static $api;
    
    /**
     * @var \Santander\Easycontract\LowLevelAPI\Base\Logger 
     */
    public static $logger;
    
    /**
     * @var boolean 
     */
    private static $_isRunning = FALSE;
    
    public static function run(\Santander\Easycontract\LowLevelAPI\Base\APIConnectorInterface $config) {
        static::$api = new static(new Config($config));
        static::$logger = Logger::getInstance();
        self::$_isRunning = TRUE;
    }
    
    public static function isRunning() {
        return self::$_isRunning;
    }
    
    public static function version() {
        return '2.0.0';
    }
    
    private function __construct(\Santander\Easycontract\LowLevelAPI\Base\Config $config) {
        $this->config = $config;
    }
    
    public function __get($name) {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        else {
            throw \Exception('The property ' . get_called_class() . '::' . $name . ' is not readable.');
        }
    }
    
    public function __set($name, $value) {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        }
        else {
            throw \Exception('The property ' . get_called_class() . '::' . $name . ' is not writeable');
        }
    }
    
    public function __isset($name) {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$gettter() === NULL;
        }
        else {
            throw \Exception('The property ' . get_called_class() . '::' . $name . ' is not readable.');
        }
    }
    
    public function __unset($name) {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            return $this->$setter(NULL);
        }
        else {
            throw \Exception('The property ' . get_called_class() . '::' . $name . ' is not writeable');
        }
    }
    
    public function getConfig() {
        return $this->config;
    }
    
    /**
     * Return soap client object
     * @param array $options
     */
    public function getSoapClient($options = array()) {
        // initiate soap client
        $soapHeaders = SoapHeaders::getBaseHeaders(TransactionHelper::getBaseTransactionId(), $this->config->getSiteName(), 'Santander Consumer Bank');

        // Market/Country
        $market = $this->config->getMarket();
        $soapHeaders->Country = $market->country;

        // Login
        $login = new Login();
        $login->Identity = $this->config->getUsername();
        $login->Password = $this->config->getPassword();
        $login->AuthorizationType = AuthorizationType::Store;
        $login->IdentificationType = IdentificationType::UserAndPassword;

        // Authentication
        $authentication = new Authentication($login);
        $soapHeaders->Authentication = $authentication;

        // Identifiers
        $identifier = new Identifier();
        $identifier->IdentifierType = IdentifierType::Store;
        $identifier->Value = $this->config->getStoreId();
        $identifiers = new Identifiers();
        $identifiers->Identifier = $identifier;
        $soapHeaders->Identifiers = $identifiers;
        
        if ($this->config->getEnableExtendedLogging()) {
            $options['trace'] = TRUE;
        }
        
        $client = new SoapClient($this->config->getWsdlUrl(), $options);
        $client->__setSoapHeaders(new \SoapHeader('http://schemas.gemoneybank.se/sit/2007/1', 'SecureIntegrationTransaction', $soapHeaders));
        
        return $client;
    }
    
    /**
     * Return token from webservice
     * @param string $orderNumber
     * @param string $purchaseAmount
     * @return Santander\Easycontract\LowLevelAPI\Model\Token|null
     */
    public function getToken($orderNumber, $purchaseAmount) {
        static::$logger->notice('GetToken', 'Called ' . __METHOD__);
        
        try {
            $market = $this->config->getMarket();
            $request = new GetTokenRequest();
            $request->Currency = $market->currency;
            $request->StoreId = $this->config->getStoreId();
            $request->StoreIdentifier = $orderNumber;
            $request->PurchaseAmount = round($purchaseAmount, 2);
            $request->MerchantNumber = $this->config->getMerchantId(); // Mandatory even if not used
            $request->CampaignCode = ""; // If no campaign code, it HAS to be set to empty string.
            $request->DynamicReturnURL = $this->config->getReturnUrl();
            
            $getToken = new GetToken();
            $getToken->request = $request;
            
            $client = $this->getSoapClient();
            $token = $client->GetToken($getToken);
            static::$logger->success('GetToken', 'Call to soap action GetToken', array($request, func_get_args()));
            
            if ($this->config->getEnableExtendedLogging()) {
                static::$logger->notice('GetToken', 'Soap Call', array(
                    'lastRequestHeaders' => $client->__getLastRequestHeaders(), 
                    'lastRequest' => $client->__getLastRequest(),
                    'lastResponseHeaders' => $client->__getLastResponseHeaders(),
                    'lastResponse' => $client->__getLastResponse(),
                ));
            }
            
            return $this->processToken($token);
        }
        catch (\Exception $ex) {
            static::$logger->error('GetToken', 'Call to soap action GetToken', array('exception message' => $ex->getMessage(), func_get_args()));
            return NULL;
        }
    }
    
    /**
     * Get resilt from webservice
     * @param string $token
     * @param string $orderNumber
     * @return \Santander\Easycontract\LowLevelAPI\Model\Result|null
     */
    public function getResult($token, $orderNumber) {
        static::$logger->notice('GetResult', 'Called ' . __METHOD__);
        
        try {
            $token = str_replace(array('/', '+'), array('%2f', '%2b'), $token);
            $request = new GetResultRequest();
            $request->StoreId = $this->config->getStoreId();
            $request->StoreIdentifier = $orderNumber;
            $request->Token = $token;
            
            $getResult = new GetResult();
            $getResult->request = $request;
            
            $client = $this->getSoapClient();
            $result = $client->GetResult($getResult);
            static::$logger->success('GetResult', 'Call to soap action GetResult', array($request, func_get_args()));
            
            if ($this->config->getEnableExtendedLogging()) {
                static::$logger->notice('GetResult', 'Soap Call', array(
                    'lastRequestHeaders' => $client->__getLastRequestHeaders(), 
                    'lastRequest' => $client->__getLastRequest(),
                    'lastResponseHeaders' => $client->__getLastResponseHeaders(),
                    'lastResponse' => $client->__getLastResponse(),
                ));
            }
            
            return $this->processResult($result);
        }
        catch (\Exception $ex) {
            static::$logger->error('GetResult', 'Call to soap action GetResult', array('exception message' => $ex->getMessage(), func_get_args()));
            return NULL;
        }
    }
    
    /**
     * Test connection towards the web service.
     * @return boolean
     */
    public function testConnection() {
        static::$logger->notice('TestConnection', 'Called ' . __METHOD__);
        
        try {
            $request = new TestConnectionRequest();
            $request->StoreId = $this->config->getStoreId();
            $request->CampaignId = mt_rand(1, 1000);
            $request->Status = mt_rand(1, 10);
            
            $testConnection = new TestConnection();
            $testConnection->request = $request;
            
            $client = $this->getSoapClient();
            $result = $client->TestConnection($testConnection);
            static::$logger->success('TestConnection', 'Call to soap action TestConnection', array($request, func_get_args()));
            
            if ($this->config->getEnableExtendedLogging()) {
                static::$logger->notice('TestConnection', 'Soap Call', array(
                    'lastRequestHeaders' => $client->__getLastRequestHeaders(), 
                    'lastRequest' => $client->__getLastRequest(),
                    'lastResponseHeaders' => $client->__getLastResponseHeaders(),
                    'lastResponse' => $client->__getLastResponse(),
                ));
            }
            
            static::$logger->success('TestConnection', 'Got result from the SOAP call', array($result));
            return (isset($result->TestConnectionResult) && $result->TestConnectionResult == $request->Status);
        }
        catch (\Exception $ex) {
            static::$logger->error('TestConnection', 'Call to soap action TestConnection', array('exception message' => $ex->getMessage(), func_get_args()));
            return NULL;
        }
    }
    
    /**
     * Ping host to check if it is available
     * @param string $env 'wsdl' or 'sf'
     * @return boolean|string
     */
    public function pingHost($env = 'wsdl') {
        require_once SANTANDER_BASE_PATH . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'ping' . DIRECTORY_SEPARATOR . 'JJG' . DIRECTORY_SEPARATOR . 'Ping.php';
        
        switch ($env) {
            case 'wsdl':
                $url = $this->config->getWsdlUrl();
                break;
            case 'sf':
                $url = $this->config->getRedirectUrl(uniqid());
                break;
        }
        
        $host = parse_url($url, PHP_URL_HOST);
        if ($host) {
            $result = array('host' => $host);
            $ping = new \JJG\Ping($host);
            
            if ($latency = $ping->ping()) {
                $result['latency'] = $latency;
                static::$logger->success('Ping', 'Pinged host ' . $host . ' using \'exec\' method', $result);
            }
            elseif ($latency = $ping->ping('fsockopen')) {
                $result['latency'] = $latency;
                static::$logger->success('Ping', 'Pinged host ' . $host . ' using \'fsockopen\' method', $result);
            }
            else {
                $result['latency'] = FALSE;
                static::$logger->error('Ping', 'Failed to ping host ' . $host, $result);
            }
            
            return $result;
        }
        else {
            static::$logger->warning('Ping', 'Unable to parse host from url ' . $url);
            return FALSE;
        }
    }
    
    /**
     * Test connection to Santander webservice
     * @param string $env
     * @return array
     */
    public function getTransferInformation($env = 'wsdl') {
        $return = array();
        
        switch ($env) {
            case 'wsdl':
                $url = $this->config->getWsdlUrl();
                break;
            case 'sf':
                $url = $this->config->getRedirectUrl(uniqid());
                break;
        }
        
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);   
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Consid Low Level API - CURL TEST');
            
            $result = curl_exec($ch);
            $errtext = curl_error($ch);
            $errnum = curl_errno($ch);
            $info = @curl_getinfo($ch);
            
            if ($errnum == 0) {
                static::$logger->success('Connection Test', 'Success! Connected to to ' . $url, array($info));
            }
            else {
                static::$logger->error('Connection Test', 'Error! Unable to connect to ' . $url, array($info, $result, $errnum, $errtext));
            }
            
            $return = array(
                'result' => $result,
                'errtext' => $errtext,
                'errnum' => $errnum,
                'info' => $info,
                'success' => $errnum == 0,
            );
            
            curl_close($ch);
        }
        
        return $return;
    }
    
    /**
     * Get the requirements for the API to work properly
     * @return array
     */
    public function getRequirements() {
        $requirements = array();
        
        // PHP version 5.3.0 or greater
        $validPhpVersion = version_compare(PHP_VERSION, '5.3.0') >= 0;
        $requirements['phpVersion'] = array(
            'label' => Message::translate('PHP version (5.3.0 or greater)'),
            'info' => $validPhpVersion ? Message::translate('valid ({phpVersion})', array('phpVersion' => PHP_VERSION)) : Message::translate('invalid ({phpVersion})', array('phpVersion' => PHP_VERSION)),
            'result' => $validPhpVersion,
        );
        
        // SoapClient class must exist
        $soapClientExists = class_exists('SoapClient', FALSE);
        $requirements['SoapClient'] = array(
            'label' => Message::translate('PHP SoapClient class'),
            'info' =>  $soapClientExists ? Message::translate('exists') : Message::translate('not exist'),
            'result' => $soapClientExists,
        );
        
        // cURL must be enabled
        $curlEnabled = function_exists('curl_init');
        $requirements['cURL'] = array(
            'label' => Message::translate('cURL'),
            'info' =>  $curlEnabled ? Message::translate('enabled') : Message::translate('not enabled'),
            'result' => $curlEnabled,
        );
        
        return $requirements;
    }
    
    /**
     * Convert soap response into Token model.
     * @param \stdClass $webserviceResponse
     * @return \Santander\Easycontract\LowLevelAPI\Model\Token
     */
    protected function processToken($webserviceResponse) {
        static::$logger->notice('Process Token', 'Called ' . __METHOD__);
        static::$logger->notice('Process Token', 'Webservice result', array($webserviceResponse));
        
        $model = new Token();
        
        if ($webserviceResponse === NULL) {
            static::$logger->error('Process Token', 'Unable to fetch token from web server', array('webserviceResponse' => $webserviceResponse));
            return $model;
        }
        
        if (!isset($webserviceResponse->GetTokenResult)) {
            static::$logger->error('Process Token', 'Unable to read token result from web service. It has an unexpected format.', array('webserviceResponse' => $webserviceResponse));
            return $model;
        }
        
        $result = $webserviceResponse->GetTokenResult;
        $token = NULL;
        $resultCode = NULL;
        
        if (isset($result->Token)) {
            $token = $result->Token;
        }
        else {
            static::$logger->error('Process Token', 'Unable to read token result from web service. It has an unexpected format.', array('webserviceResponse' => $webserviceResponse));
        }
        
        if (isset($result->ResultCode)) {
            $resultCode = $result->ResultCode;
        }
        else {
            static::$logger->error('Process Token', 'Unable to read token result from web service. It has an unexpected format.', array('webserviceResponse' => $webserviceResponse));
        }
        
        if ($resultCode == 0) {
            $model->isOk = TRUE;
            $model->token = $token;
            $model->resultCode = $resultCode;
            static::$logger->success('Process Token', 'Got token from web service', array(
                'Token' => substr($token, 0, 16) . ' (clipped)',
                'ResultCode' => $resultCode,
            ));
        }
        else {
            $model->isOk = FALSE;
            $model->errorMessage = Message::translate('An error occured while communicating with Santander Consumer Bank. Try again or choose another payment method.');
            static::$logger->error('Process Token', 'Failed to get token from web service.', array('ResultCode' => $resultCode));
        }
        
        static::$logger->notice('Process Token', 'Token finished processing', array($model));
        
        return $model;
    }
    
    /**
     * Convert soap response into Result model
     * @param \stdClass $webserviceResponse
     * @return \Santander\Easycontract\LowLevelAPI\Model\Result
     */
    protected function processResult($webserviceResponse) {
        static::$logger->notice('Process Result', 'Called ' . __METHOD__);
        static::$logger->notice('Process Result', 'Webservice result', array($webserviceResponse));
        
        $model = new Result();
        
        if ($webserviceResponse === NULL) {
            static::$logger->error('Process Result', 'Unable to fetch result from web server', array('webserviceResponse' => $webserviceResponse));
            return $model;
        }
        
        if (!isset($webserviceResponse->GetResultResult)) {
            static::$logger->error('Process Result', 'Unable to read result result from web service. It has an unexpected format.', array('webserviceResponse' => $webserviceResponse));
            return $model;
        }
        
        $result = $webserviceResponse->GetResultResult;
        $resultCode = NULL;
        
        if (isset($result->ResultCode)) {
            $resultCode = $result->ResultCode;
            static::$logger->success('Process Result', 'Got result from web service', array('ResultCode' => $resultCode));
        }
        else {
            static::$logger->error('Process Result', 'Unable to read result result from web service. It has an unexpected format.', array('webserviceResponse' => $webserviceResponse));
        }
        
        $model->isOk = $resultCode == 0;
        $model->resultCode = $resultCode;
        $model->isAbortedByCustomer = $this->isAbortedByCustomer($resultCode);
        $model->address = $this->getAddressInfo($result);
        $model->humanFailureMessage = $this->getUserFriendlyMessage($resultCode);
        
        if (isset($result->AuthorizationCode)) {
            $model->authorizationCode = $result->AuthorizationCode;
        }
        
        static::$logger->notice('Process Result', 'Result finished processing', array($model));
        
        return $model;
    }
    
    /* These are the result codes available. 
     * From the document e@sy_SF_webshop_integration_ 3.0, section 4.

       0 OK. The customer has signed the contract and the purchase amount is authorized.
       105 Back end systems not on-line
       110 Invalid Request. Input data error or wrong credentials for web shop log on.
       200 Customer aborted process before first page is shown
       201 Customer aborted process after viewing first page (Option page)
       202 Customer aborted process after viewing second page (product page)
       203 Customer aborted process after successful e-certificate authentication
       204 Customer aborted process after approval, but before signing contract
       207 Customer has chosen to abort the process. This is a general code that is returned if
           origin ins not known (navigation failure, navigation backwards between pages)
       210 The customer has already created an application and it is not possible to create a new
       before the old one is removed
       211 Application was rejected by our origination system
       300 Authorization failed. Customer has applied and signed the credit, but authorization of
       the purchase amount has failed. Customer will receive his card but web shop cannot
       capture the purchase amount..
       909 Different kind of technical problems.
       310 Settlementfailed
     */
    
    /**
     * Get a user friendly message based on the ResultCode from the webservice response.
     * @param integer $resultCode
     * @return string
     */
    public function getUserFriendlyMessage($resultCode) {
        $key = "RETURN_CODE_DESCRIPTION_$resultCode";
        return Message::translate($key);
    }
    
    /**
     * Return address information from web service response.
     * @param GetResultResult $result
     * @return \Santander\Easycontract\LowLevelAPI\Model\Address
     */
    public function getAddressInfo($result) {
        static::$logger->notice('Process Address Information', 'Called ' . __METHOD__);
        
        $address = new Address();
        
        if (isset($result->FirstName)) {
            $address->firstName = $result->FirstName;
        }
        
        if (isset($result->LastName)) {
            $address->lastName = $result->LastName;
        }
        
        if (isset($result->Address)) {
            $address->address = $result->Address;
        }
        
        if (isset($result->City)) {
            $address->city = $result->City;
        }
        
        if (isset($result->PostCode)) {
            $address->postCode = $result->PostCode;
        }
        
        return $address;
    }
    
    /**
     * Check if the application was canceled by customer
     * @param integer $resultCode
     * @return boolean
     */
    public function isAbortedByCustomer($resultCode) {
        $customerAbortedCodes = array(200, 201, 202, 203, 204, 207);
        return in_array($resultCode, $customerAbortedCodes);
    }
    
    /**
     * Delete the session holding the BaseTransactionId
     */
    public function resetBaseTransactionId() {
        TransactionHelper::resetBaseTransactionId();
    }
    
    /**
     * Finish order and trigger $callback.
     * @param string $callback
     */
    public function finishOrder($callback = NULL) {
        $this->resetBaseTransactionId();
        static::$logger->success('Order', 'A new order has been completed.');
        
        if (is_callable($callback)) {
            call_user_func($callback);
        }
    }
    
    /**
     * Translate and output text.
     * @param string $message
     * @param array|null $params
     * @return string
     */
    public function _($message, $params = array()) {
        return Message::translate($message, $params);
    }
}