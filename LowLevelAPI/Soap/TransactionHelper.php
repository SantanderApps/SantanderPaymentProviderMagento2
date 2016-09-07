<?php

/**
 * TransactionHelper
 *
 * @file TransactionHelper.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap;

/**
 * Helper class for transaction to EasyContract webservice.
 */
class TransactionHelper {
    /**
     * Unique identifier for the transaction chain supplied by the caller.
     * Returns the base transaction ID.
     * @return string
     */
    public static function getBaseTransactionId() {
        if (!isset($_SESSION['__baseTransactionId'])) {
            $_SESSION['__baseTransactionId'] = uniqid('', true);
        }
        
        return $_SESSION['__baseTransactionId'];
    }
    
    /**
     * Delete the session holding the BaseTransactionId
     */
    public static function resetBaseTransactionId() {
        unset($_SESSION['__baseTransactionId']);
    }
    
    /**
     * Unique ID for every single transaction.
     * Returns a unique transaction ID.
     * @return string
     */
    public static function getTransactionId() {
        return uniqid('', true);
    }
}
