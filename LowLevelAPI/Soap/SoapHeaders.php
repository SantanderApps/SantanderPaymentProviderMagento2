<?php

/**
 * SoapHeaders
 *
 * @file SoapHeaders.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap;

class SoapHeaders {
    /**
     * Returns base headers
     * @param string $baseTransactionId
     * @param string|null $senderId
     * @param string|null $receiverId
     * @return \Santander\Easycontract\LowLevelAPI\Soap\BaseHeaders
     */
    public static function getBaseHeaders($baseTransactionId, $senderId = NULL, $receiverId = NULL) {
        return new BaseHeaders($baseTransactionId, $senderId, $receiverId);
    }
}

class BaseHeaders {
    /**
     * Unique identifier for the transaction chain supplied by the caller.
     * @var string 
     */
    public $BaseTransactionId;
    
    /**
     * Unique ID for every single transaction
     * @var string 
     */
    public $TransactionId;
    
    /**
     * Country code
     * @var string 
     */
    public $Country;
    
    /**
     * Channel name
     * @var string 
     */
    public $Channel;
    
    /**
     * The user's IP address
     * @var string 
     */
    public $ClientIPAddress;
    
    /**
     * The server's IP address
     * @var string 
     */
    public $CallerIPAddress;
    
    /**
     * The server's hostname
     * @var string 
     */
    public $CallerMachineName;
    
    /**
     * Identifies the caller this value is given to the consumer of a web service 
     * by GE Money Bank. 
     * Type attribute states which kind of identifier is used.
     * @var string 
     */
    public $SenderId;
    
    /**
     * Identifies the destination/receiver this value is given to the consumer 
     * of a web service by GE Money Bank. 
     * Type attribute states which kind of identifier is used
     * @var string 
     */
    public $ReceiverId;
    
    /**
     * Value: 'None'
     * @var string 
     */
    public $AsynchronousMethod;
    
    /**
     * Value: 'None'
     * @var string
     */
    public $AsynchronousFailover;
    
    /**
     * Used to authenticate a store or a user
     * @var \Santander\Easycontract\LowLevelAPI\Soap\Authentication 
     */
    public $Authentication;
    
    /**
     *
     * @var Identifiers 
     */
    public $Identifiers;
    
    public function __construct($baseTransactionId, $senderId = NULL, $receiverId = NULL) {
        $this->BaseTransactionId = $baseTransactionId;
        $this->TransactionId = TransactionHelper::getTransactionId();
        $this->Channel = Channels::EASY;
        $this->ClientIPAddress = $_SERVER['REMOTE_ADDR'];
        $this->CallerIPAddress = $_SERVER['SERVER_ADDR'];
        $this->CallerMachineName = $_SERVER['SERVER_NAME'];
        $this->SenderId = $senderId;
        $this->ReceiverId = $receiverId;
        $this->AsynchronousMethod = 'None'; // Not sure what this is, documentation missing
        $this->AsynchronousFailover = 'None'; // Not sure what this is, documentation missing
    }
}
