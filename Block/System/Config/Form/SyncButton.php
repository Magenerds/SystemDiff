<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Block\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class SyncButton extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Magenerds_SystemDiff::system/config/sync_button.phtml';

    /**
     * @var AbstractElement
     */
    protected $element;

    /**
     * Remove scope label
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        // used later in getButtonHtml
        $this->element = $element;

        return $this->_toHtml();
    }

    /**
     * Return ajax url for diff button
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('magenerds/systemdiff/diff');
    }

    /**
     * Generate diff button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        /** @var \Magento\Backend\Block\Widget\Button $button */
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        );
        $button->setData(
            [
                'id' => $this->element->getHtmlId(),
                'label' => __('Run'),
                'class' => 'disabled' // reset when page loaded, see template script
            ]
        );

        return $button->toHtml();
    }

    /**
     * Returns the element defined in system.xml
     *
     * @return AbstractElement
     */
    public function getElement()
    {
        return $this->element;
    }
}