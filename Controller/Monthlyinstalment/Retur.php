<?php

/**
 * Retur
 *
 * @file Retur.php
 * @author Henrik Söderlind <henrik.soderlind@live.se>
 * @created 2016-maj-27
 */

namespace Santander\Easycontract\Controller\Monthlyinstalment;

use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;

class Retur extends \Magento\Framework\App\Action\Action {
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
        $reservedOrderId = $this->_session->getECOrderId();
        $result = $this->_apiHelper->api
            ->getResult($_GET['token'], $reservedOrderId);
        
        if ($result !== null || $result->isOk) {
            $this->_response->setRedirect(
                $this->_url->getUrl('checkout/onepage/success/')
            );
        } else {
            $this->messageManager->addError($result->humanFailureMessage);
            $this->_response->setRedirect(
                $this->_url->getUrl('checkout/')
            );
        }
    }
}
