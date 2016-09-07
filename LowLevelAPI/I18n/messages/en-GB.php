<?php

/**
 * @file en-GB.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 1.0.0
 * @created 2015-aug-04
 */

return array(
    // General
    'Santander Consumer Bank' => 'Santander Consumer Bank',
    '<strong>Version:</strong> {versionNumber}' => '<strong>Version:</strong> {versionNumber}',
    
    // Check requirements
    'PHP version (5.3.0 or greater)' => 'PHP version (5.3.0 or greater)', 
    'valid ({phpVersion})' => 'valid ({phpVersion})',
    'invalid ({phpVersion})' => 'invalid ({phpVersion})',
    'PHP SoapClient class' => 'PHP SoapClient class',
    'exists' => 'exists',
    'not exist' => 'not exist',
    'cURL' => 'cURL',
    'enabled' => 'enabled',
    'not enabled' => 'not enabled',
    
    // Module Configuration
    'Available Markets' => 'Available Markets',
    'Sweden' => 'Sweden',
    'Denmark' => 'Denmark',
    'Norway' => 'Norway',
    'Finland' => 'Finland',
    'Great Britain' => 'Great Britain',
    'Test connection with the web service' => 'Test connection with the web service',
    'Result' => 'Result',
    'Success! Connected to {host}' => 'Success! Connected to {host}',
    '<p>Error! Failed to connect to {host}.<br>It may be due to some of the following reasons:</p><ul><li>The server is not available at the moment.</li><li>Your server do not have an outbound Internet connection.</li></ul>' => '<p>Error! Failed to connect to {host}.<br>It may be due to some of the following reasons:</p><ul><li>The server is not available at the moment.</li><li>Your server do not have an outbound Internet connection.</li></ul>',
    'Success! Connected to {host}' => 'Success! Connected to {host}',
    '<p>Error! Failed to connect to {host}.<br>It may be due to some of the following reasons:</p><ul><li>The server is not available at the moment.</li><li>Your server do not have an outbound Internet connection.</li></ul>' => '<p>Error! Failed to connect to {host}.<br>It may be due to some of the following reasons:</p><ul><li>The server is not available at the moment.</li><li>Your server do not have an outbound Internet connection.</li></ul>',
    'Verify user details' => 'Verify user details',
    '<strong>Note:</strong> Only available when "Module Environment" is set to "{statusLive}".' => '<strong>Note:</strong> Only available when "Module Environment" is set to "{statusLive}".',
    'Success! The test connection with the web service works great. Your account details is correct.' => 'Success! The test connection with the web service works great. Your account details is correct.',
    'Error! The test connection with the web service failed. It seems like your account details are incorrect. Make sure that they are correct, if it still doesn\'t work please {contactUs}.' => 'Error! The test connection with the web service failed. It seems like your account details are incorrect. Make sure that they are correct, if it still doesn\'t work please <a href="http://santander.consid.se/site/contact?department=1" target="_blank">contact the support</a>.',
    'Enable / Disable' => 'Enable / Disable',
    'Enable Santander Consumer Bank' => 'Enable Santander Consumer Bank',
    'Store ID' => 'Store ID',
    'Type the store ID given to you by Santander Consumer Bank.' => 'Type the store ID given to you by Santander Consumer Bank.',
    'Username' => 'Username',
    'Type the username given to you by Santander Consumer Bank.' => 'Type the username given to you by Santander Consumer Bank.',
    'Password' => 'Password',
    'Type the password given to you by Santander Consumer Bank.' => 'Type the password given to you by Santander Consumer Bank.',
    'Merchant ID' => 'Merchant ID',
    'Type the merchant ID given to you by your payment service provider.' => 'Type the merchant ID given to you by your payment service provider.',
    'Set Module Environment' => 'Set Module Environment',
    'Enable sandbox/test environment' => 'Enable sandbox/test environment',
    'Version' => 'Version',
    'Test Connections' => 'Test connection with web services.',
    '<strong>Note:</strong> Only available when "Set Module Environment" is unchecked.' => '<strong>Note:</strong> Only available when "Set Module Environment" is unchecked.',
    'Support Logs' => 'Support Logs',
    'For a better support experience Santander´s plugin logs all connections to and from Santander´s web services. You have the option to opt-out of these logs being automatically collected by Santander and can therefore choose to manually send in a log file when contacting Santander support services. Log files are located: {logdir}.' => 'For a better support experience Santander´s plugin logs all connections to and from Santander´s web services. You have the option to opt-out of these logs being automatically collected by Santander and can therefore choose to manually send in a log file when contacting Santander support services. Log files are located: {logdir}.',
    "New order status" => "New order status",
    "Status of order when order created, but before it has been processed by Santander Consumer Bank" => "Status of order when order created, but before it has been processed by Santander Consumer Bank",
    
    // Order Comments
    'Santander Consumer Bank order number: {orderNumber}' => 'Santander Consumer Bank order number: {orderNumber}',
    'Authorization receipt to be used when capturing the amount from your payment service provider: {authorizationCode}' => 'Authorization receipt to be used when capturing the amount from your payment service provider: {authorizationCode}',
    'Payment could not be completed. Result code: {resultCode}.' => 'Payment could not be completed. Result code: {resultCode}.',
    
    // Log mail
    'Log file from {system}' => 'Log file from {system}', 
    'Log file from {yesterday} for {system} is attached in this e-mail.' => 'Log file from {yesterday} for {system} is attached in this e-mail.',
    
    // Checkout
    'Proceed to Santander' => 'Proceed to Santander',
    'The customer was redirected from Santander Consumer Bank\'s web site back to the shop.' => 'The customer was redirected from Santander Consumer Bank\'s web site back to the shop.',
    'You canceled the payment at the Santander Consumer Bank web site.' => 'You canceled the payment at the Santander Consumer Bank web site.',
    'Payment could not be completed.' => 'Payment could not be completed.',
    'Message displayed to customer' => 'Message displayed to customer',
    
    // Checkout error messages
    'A technical problem occurred when the order was processed. The order has been canceled.' => 'A technical problem occurred when the order was processed. The order has been canceled.',
    'An error occured while communicating with Santander Consumer Bank. Try again or choose another payment method.' => 'An error occured while communicating with Santander Consumer Bank. Try again or choose another payment method.',
    'RETURN_CODE_DESCRIPTION_0' => '',
    'RETURN_CODE_DESCRIPTION_105' => 'An unexpected technical issue has occured.',
    'RETURN_CODE_DESCRIPTION_110' => 'An unexpected technical issue has occured.',
    'RETURN_CODE_DESCRIPTION_200' => 'You have choosen to cancel the application (error code 200)',
    'RETURN_CODE_DESCRIPTION_201' => 'You have choosen to cancel the application (error code 201)',
    'RETURN_CODE_DESCRIPTION_202' => 'You have choosen to cancel the application (error code 202)',
    'RETURN_CODE_DESCRIPTION_203' => 'You have choosen to cancel the application (error code 203)',
    'RETURN_CODE_DESCRIPTION_204' => 'You have choosen to cancel the application (error code 204)',
    'RETURN_CODE_DESCRIPTION_207' => 'You have choosen to cancel the application (error code 207)',
    'RETURN_CODE_DESCRIPTION_210' => 'You have already started an application. Call Santander Consumer Bank if you wish to complete your application (error code 210)',
    'RETURN_CODE_DESCRIPTION_211' => 'An unexpected technical issue has occured. Please, inform the shop owner (error code 211)',
    'RETURN_CODE_DESCRIPTION_300' => 'An unexpected technical issue has occured. Please, inform the shop owner (error code 300)',
    'RETURN_CODE_DESCRIPTION_909' => 'An unexpected technical issue has occured. Please, inform the shop owner (error code 909)',
    'RETURN_CODE_DESCRIPTION_310' => 'An unexpected technical issue has occured. Please, inform the shop owner (error code 310)',
);