<?php
/**
 * MonthlyInstalment
 *
 * @file MonthlyInstalment.php
 * @author Consid AB <henrik.soderlind@consid.se>
 * @created 2016-mar-23
 */

namespace Santander\Easycontract\Model;

class MonthlyInstalment extends \Magento\Payment\Model\Method\AbstractMethod
{
    
    const STATUS_TEST = 'test';
    
    const STATUS_PRODUCTION = 'production';

    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'monthlyinstalment';
    
    /**
     * Payment Method feature
     *
     * @var bool
     */
    protected $_isGateway = true;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = false;
    
    //protected $_canCapture = true;
    protected $_isInitializeNeeded = true;
    
    /**
     *
     * @var \Santander\Easycontract\Helper\LowLevelApiHelper 
     */
    protected $_apiHelper;
    
    /**
     *
     * @var \Magento\Checkout\Helper\Cart 
     */
    protected $_cart;
    
    /**
     *
     * @var \Magento\Catalog\Model\Session 
     */
    protected $_session;
    
    public function __construct(
        \Magento\Framework\Model\Context $context, 
        \Magento\Framework\Registry $registry, 
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, 
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, 
        \Magento\Payment\Helper\Data $paymentData, 
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
        \Magento\Payment\Model\Method\Logger $logger, 
        \Magento\Checkout\Helper\Cart $cart, 
        \Magento\Catalog\Model\Session $session, 
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, 
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, 
        array $data = array())
    {
        parent::__construct(
            $context, 
            $registry, 
            $extensionFactory, 
            $customAttributeFactory, 
            $paymentData, 
            $scopeConfig, 
            $logger, 
            $resource, 
            $resourceCollection, 
            $data
        );
        
        /* @var $lowLevelApiHelp \Santander\Easycontract\Helper\LowLevelApiHelper */
        $lowLevelApiHelper = \Magento\Framework\App\ObjectManager::getInstance()->get('\Santander\Easycontract\Helper\LowLevelApiHelper');
        $this->_apiHelper = $lowLevelApiHelper;
        $this->_cart = $cart;
        $this->_session = $session;
    }
    
    public function initialize($paymentAction, $stateObject) {
        return parent::initialize($paymentAction, $stateObject);
    }
    
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null) {
        $reservedOrderId = $quote->reserveOrderId()->getReservedOrderId();
        $subTotal = $quote->getSubtotal();
        
        try {
            $token = $this->_apiHelper->api->getToken($reservedOrderId, $subTotal);

            if ($token !== null || $token->isOk) {
                $this->_session->setECToken($token);
                $this->_session->setECOrderId($reservedOrderId);
            } else {
                return false;
            }

            return parent::isAvailable($quote);
        } catch (\Exception $ex) {
            return false;
        }
    }
}
