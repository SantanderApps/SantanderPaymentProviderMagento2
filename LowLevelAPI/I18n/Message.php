<?php

/**
 * Message
 *
 * @file Message.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\I18n;

use Santander\Easycontract\LowLevelAPI\App;

class Message {
    /**
     * Translate a source message into target language $language.
     * @staticvar array $sourceMessages
     * @staticvar array $targetMessages
     * @param string $message
     * @param array $params
     * @param Language|string|null $language
     * @return string
     */
    public static function translate($message, $params = array(), $language = NULL) {
        static $sourceMessages = array(), $targetMessages = array();
        
        if (empty($language)) {
            $l = App::$api->config->getLanguage();
            $language = new Language($l);
        } elseif (is_string($language)) {
            $language = new Language($language);
        }
        
        if (empty($sourceMessages)) {
            $sourceLanguageObject = new Language($language->getDefaultLanguage());
            $sourceMessages = $sourceLanguageObject->getMessages();
        }
        
        if (!isset($targetMessages[$language->getLanguage()])) {
            $targetMessages[$language->getLanguage()] = $language->getMessages();
        }
        
        if (isset($targetMessages[$language->getLanguage()][$message])) {
            return static::_formatString($targetMessages[$language->getLanguage()][$message], $params);
        }
        else {
            return static::_formatString($sourceMessages[$message], $params);
        }
    }
    
    /**
     * Format a string into a human readable message.
     * @param string $message
     * @param array $params
     * @return string
     */
    private static function _formatString($message, $params = array()) {
        if (empty($params)) {
            return $message;
        }
        
        foreach ($params as $key => $value) {
            $params['{' . $key . '}'] = $value;
        }
        
        return strtr($message, $params);
    }
}
