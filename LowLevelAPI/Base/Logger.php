<?php

/**
 * Logger
 *
 * @file Logger.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-05
 */

namespace Santander\Easycontract\LowLevelAPI\Base;

use Santander\Easycontract\LowLevelAPI\App;
use Santander\Easycontract\LowLevelAPI\I18n\Message;
use Santander\Easycontract\LowLevelAPI\I18n\Language;

class Logger {
    const LEVEL_NOTICE = 'NOTICE';
    const LEVEL_SUCCESS = 'SUCCESS';
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_ERROR = 'ERROR';
    
    protected $savePath;
    protected $filename;
    protected $filenameTemplate = 'santander-{date}.log';
    protected $entryTemplate = '{date} | {uri} | {browser} | {category} | {level} | {message} | {store_id} | {merchant_id} | {api_version} | {module_version} | {module_installed_at} | {platform_name} | {platform_version} | {client_ip} | {server_ip} | {additional_parameters}';
    
    private function __construct() {
        $filename = strtr($this->filenameTemplate, array('{date}' => date('Ymd')));
        
        if (!is_dir($this->getSavePath())) {
            if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' && !is_writable(dirname($this->getSavePath()))) {
                if (!@chmod(dirname($this->getSavePath()), 0775)) {
                    throw new \RuntimeException(dirname($this->getSavePath()) . ' is not writeable. Make it writeable by the server.');
                    return;
                }
            }
            
            mkdir($this->getSavePath(), 0775);
        }
        
        $this->filename = $this->getSavePath() . DIRECTORY_SEPARATOR . $filename;
    }
    
    public static function &getInstance() {
        static $self;
        if ($self === NULL) {
            $self = new static();
        }
        
        return $self;
    }
    
    /**
     * Add a log entry to log file
     * @param string $category
     * @param string $level
     * @param string $message
     * @param array $additionalParameters
     * @return boolean
     */
    public function log($category, $level, $message, array $additionalParameters = NULL) {
        if (!is_writable($this->savePath)) {
            return;
        }
        
        $replace = array(
            '{date}' => date('Y-m-d H:i:s'),
            '{uri}' => $_SERVER['REQUEST_URI'],
            '{category}' => $category,
            '{level}' => $level,
            '{store_id}' => App::$api->config->getStoreId(),
            '{merchant_id}' => App::$api->config->getMerchantId(),
            '{api_version}' => App::version(),
            '{module_version}' => App::$api->config->getModuleVersion(),
            '{module_installed_at}' => App::$api->config->getModuleInstallationDate(),
            '{browser}' => $_SERVER['HTTP_USER_AGENT'],
            '{platform_name}' => App::$api->config->getPlatformName(),
            '{platform_version}' => App::$api->config->getPlatformVersion(),
            '{message}' => $message,
            '{client_ip}' => $_SERVER['REMOTE_ADDR'],
            '{server_ip}' => $_SERVER['SERVER_ADDR'],
            '{additional_parameters}' => str_replace(array("\n", "\r", "\t"), array('', '', ''), print_r($additionalParameters, TRUE)),
        );
        
        $entry = strtr($this->entryTemplate, $replace);
        return file_put_contents($this->filename, $entry . PHP_EOL, FILE_APPEND);
    }
    
    /**
     * Add a log entry of type notice to the log file
     * @param string $category
     * @param string $message
     * @param array $additionalParameters
     * @return integer
     */
    public function notice($category, $message, array $additionalParameters = NULL) {
        return $this->log($category, static::LEVEL_NOTICE, $message, $additionalParameters);
    }
    
    /**
     * Add a log entry of type success to the log file
     * @param string $category
     * @param string $message
     * @param array $additionalParameters
     * @return integer
     */
    public function success($category, $message, array $additionalParameters = NULL) {
        return $this->log($category, static::LEVEL_SUCCESS, $message, $additionalParameters);
    }
    
    /**
     * Add a log entry of type warning to the log file
     * @param string $category
     * @param string $message
     * @param array $additionalParameters
     * @return integer
     */
    public function warning($category, $message, array $additionalParameters = NULL) {
        return $this->log($category, static::LEVEL_WARNING, $message, $additionalParameters);
    }
    
    /**
     * Ass a log entry of type error to the log file
     * @param string $category
     * @param string $message
     * @param array $additionalParameters
     * @return integer
     */
    public function error($category, $message, array $additionalParameters = NULL) {
        return $this->log($category, static::LEVEL_ERROR, $message, $additionalParameters);
    }
    
    /**
     * Return the contents of the log file.
     * @param integer $timestamp the timestamp of the date of the log file
     * @return string
     */
    public function getLogFile($timestamp) {
        $filename = $this->getSavePath() . DIRECTORY_SEPARATOR . strtr($this->filenameTemplate, array('{date}' => $timestamp));
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
    }
    
    public function getSavePath() {
        if (empty($this->savePath)) {
            $defaultSavePath = SANTANDER_BASE_PATH . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'log';
            if (App::$api->config instanceof Config) {
                $savePath = App::$api->config->getLogDir();
                if (!empty($savePath)) {
                    $this->savePath = $savePath;
                }
                else {
                    $this->savePath = $defaultSavePath;
                }
            }
            else {
                $this->savePath = $defaultSavePath;
            }
        }
        
        return $this->savePath;
    }
}
