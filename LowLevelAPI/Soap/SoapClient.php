<?php

/**
 * SoapClient
 *
 * @file SoapClient.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap;

class SoapClient extends \SoapClient {
    private static $classmap = array(
        'GetResult' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResult',
        'GetResultRequest' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResultRequest',
        'GetResultResponse' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResultResponse',
        'TestConnection' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnection',
        'TestConnectionRequest' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnectionRequest',
        'TestConnectionResponse' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnectionResponse',
        'GetToken' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetToken',
        'GetTokenRequest' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetTokenRequest',
        'GetTokenResult' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetTokenResult',
        'HelloWorld' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\HelloWorld',
        'HelloWorldResponse' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\HelloWorldResponse',
        'FinalizeTransaction' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\FinalizeTransaction',
        'GetFinalizeTransactionRequest' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetFinalizeTransactionRequest',
        'FinalizeTransactionResponse' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\FinalizeTransactionResponse',
        'GetFinalizeTransactionResponse' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetFinalizeTransactionResponse',
        'GetCampaignValues' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetCampaignValues',
        'GetCampaignValuesRequest' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetCampaignValuesRequest',
        'GetCampaignValuesResponse' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\GetCampaignValuesResponse',
        'CampaignItem' => '\Santander\Easycontract\LowLevelAPI\Soap\Actions\CampaignItem',
        'Authentication' => '\Santander\Easycontract\LowLevelAPI\Soap\Authentication',
        'Login' => '\Santander\Easycontract\LowLevelAPI\Soap\Login',
    );
    
    public function SoapClient($wsdl, $options = array()) {
        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        
        parent::SoapClient($wsdl, $options);
    }
    
    /**
     * 
     * @param \Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResult $parameters
     * @return \Santander\Easycontract\LowLevelAPI\Soap\Actions\GetResultResponse
     */
    public function GetResult(Actions\GetResult $parameters) {
        return $this->__soapCall('GetResult', array($parameters), array(
            'uri' => 'http://integration.gemoneybank.se/ws/2007/1',
            'soapaction' => '',
        ));
    }
    
    /**
     * 
     * @param \Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnection $parameters
     * @return \Santander\Easycontract\LowLevelAPI\Soap\Actions\TestConnectionResponse
     */
    public function TestConnection(Actions\TestConnection $parameters) {
        return $this->__soapCall('TestConnection', array($parameters), array(
            'uri' => 'http://integration.gemoneybank.se/ws/2007/1',
            'soapaction' => '',
        ));
    }
    
    /**
     * 
     * @param \Santander\Easycontract\LowLevelAPI\Soap\Actions\GetToken $parameters
     * @return \Santander\Easycontract\LowLevelAPI\Soap\Actions\GetTokenResponse
     */
    public function GetToken(Actions\GetToken $parameters) {
        return $this->__soapCall('GetToken', array($parameters), array(
            'uri' => 'http://integration.gemoneybank.se/ws/2007/1',
            'soapaction' => '',
        ));
    }
    
    /**
     * 
     * @param \Santander\soap\actions\HelloWorld $parameters
     * @return \Santander\soap\actions\HelloWorldResponse
     */
    public function HelloWorld(actions\HelloWorld $parameters) {
        return $this->__soapCall('HelloWorld', array($parameters), array(
            'uri' => 'http://integration.gemoneybank.se/ws/2007/1',
            'soapaction' => '',
        ));
    }
    
    /**
     * 
     * @param \Santander\Easycontract\LowLevelAPI\Soap\Actions\FinalizeTransaction $parameters
     * @return \Santander\Easycontract\LowLevelAPI\Soap\Actions\FinalizeTransactionResponse
     */
    public function FinalizeTransaction(Actions\FinalizeTransaction $parameters) {
        return $this->__soapCall('FinalizeTransaction', array($parameters), array(
            'uri' => 'http://integration.gemoneybank.se/ws/2007/1',
            'soapaction' => '',
        ));
    }
    
    public function GetCampaignValues(Actions\GetCampaignValues $parameters) {
        return $this->__soapCall('GetCampaignValues', array($parameters), array(
            'uri' => 'http://integration.gemoneybank.se/ws/2007/1',
            'soapaction' => '',
        ));
    }
}
