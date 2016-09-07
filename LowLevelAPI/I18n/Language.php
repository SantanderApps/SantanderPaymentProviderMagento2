<?php

/**
 * Language
 *
 * @file Language.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\I18n;

class Language {
    public static $languageMapping = array(
        'en-GB' => 'en-GB',
        'en' => 'en-GB',
        'en_GB' => 'en-GB',
        'english' => 'en-GB',
        'sv-SE' => 'sv-SE',
        'sv' => 'sv-SE',
        'sv_SE' => 'sv-SE',
        'swedish' => 'sv-SE',
        'svenska' => 'sv-SE',
    );
    
    const DEFAULT_LANGUAGE = 'en-GB';
    private $_language;
    private $_defaultLanguage;
    
    public function __construct($language) {
        $this->_language = isset(static::$languageMapping[$language]) ? static::$languageMapping[$language] : $language;
        $this->_defaultLanguage = static::DEFAULT_LANGUAGE;
    }
    
    public function getDefaultLanguage() {
        return $this->_defaultLanguage;
    }
    
    public function getLanguage() {
        return $this->_language;
    }
    
    public function getMessages() {
        $filename = __DIR__ . '/messages/' . $this->_language . '.php';
        if (file_exists($filename)) {
            return require_once($filename);
        }
        else {
            return require_once(__DIR__ . '/messages/' . $this->_defaultLanguage . '.php');
        }
    }
}
