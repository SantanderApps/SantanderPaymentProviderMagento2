<?php

/**
 * Button
 *
 * @file Button.php
 * @author Consid AB <henrik.sdoerlind@consid.se>
 * @created 2015-dec-02
 */

namespace Santander\Easycontract\Block\Adminhtml\System\Config;

class Button extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Path to block template
     */
    const TEMPLATE = 'system/config/test_connection.phtml';
    
    /**
     * Set template to itself
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate(static::TEMPLATE);
        }
        return $this;
    }
    
    /**
     * Unset some non-related element parameters
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    
    protected function getAjaxUrl($route)
    {
        return $this->getUrl($route);
    }
    
    /**
     * Get the button and scripts contents
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(
            [
                'button_label' => __($originalData['button_label']),
                'button_url' => $this->getAjaxUrl($originalData['button_route']),
                'html_id' => $element->getHtmlId(),
            ]
        );
        return $this->_toHtml();
    }
}
