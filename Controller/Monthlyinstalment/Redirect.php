<?php

/**
 * Redirect
 *
 * @file Redirect.php
 * @author Consid AB <henrik.soderlind@consid.se>
 * @created 2016-maj-12
 */

namespace Santander\Easycontract\Controller\Monthlyinstalment;

use Magento\Framework\App\Action\Context;

class Redirect extends \Magento\Framework\App\Action\Action {
    /**
     *
     * @var \Santander\EasyContract\Helper\LowLevelApiHelper 
     */
    protected $_apiHelper;
    
    /**
     *
     * @var \Magento\Catalog\Model\Session 
     */
    protected $_session;
    
    /**
     *
     * @var \Magento\Framework\App\Response\Http 
     */
    protected $_response;
    
    /**
     *
     * @var \Magento\Framework\Url 
     */
    protected $_url;
    
    public function __construct(
        Context $context, 
        \Magento\Catalog\Model\Session $session,
        \Magento\Framework\App\Response\Http $response
    ) {
        parent::__construct($context);
        $lowLevelApiHelper = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('\Santander\Easycontract\Helper\LowLevelApiHelper');
        $this->_url = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('\Magento\Framework\Url');
        $this->_apiHelper = $lowLevelApiHelper;
        $this->_session = $session;
        $this->_response = $response;
    }
    
    public function execute() {
        /* @var $token \Santander\Easycontract\LowLevelAPI\Model\Token */
        $token = $this->_session->getECToken();
        
        if (!$token || !$token->isOk) {
            $this->messageManager->addError(
                $token->errorMessage
            );
            $this->_response->setRedirect(
                $this->_url->getUrl('checkout/')
            );
        } else {
            $this->_response->setRedirect(
                $this->_apiHelper->api->getConfig()->getRedirectUrl($token->token)
            );
        }
    }
}
