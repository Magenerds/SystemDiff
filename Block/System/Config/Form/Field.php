<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Block\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field as CoreField;
use Magento\Backend\Block\Template\Context;
use Magenerds\SystemDiff\Helper\Config;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig\Collection;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig\CollectionFactory;
use Magenerds\SystemDiff\Model\DiffConfig;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field\Regexceptions;

class Field extends CoreField
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Field constructor.
     * @param Config $config
     * @param Context $context
     * @param [] $data
     */
    public function __construct(
        Config $config,
        CollectionFactory $collectionFactory,
        Context $context,
        array $data = []
    ){
        $this->config = $config;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $data);
    }

    /**
     * @inheritdoc
     */
    public function render(AbstractElement $element)
    {
        // if displaying is disabled, render the core logic
        if (!$this->config->isDisplayStoreConfig()) {
            return parent::render($element);
        }

        $isCheckboxRequired = $this->_isInheritCheckboxRequired($element);

        // Disable element if value is inherited from other scope. Flag has to be set before the value is rendered.
        if ($element->getInherit() == 1 && $isCheckboxRequired) {
            $element->setDisabled(true);
        }

        $html = '<td class="label"><label for="' .
            $element->getHtmlId() . '"><span' .
            $this->_renderScopeLabel($element) . '>' .
            $element->getLabel() .
            '</span></label></td>';
        $html .= $this->_renderValue($element);

        // add the diff element
        $html .= $this->_renderDiffHtml($element);

        if ($isCheckboxRequired) {
            $html .= $this->_renderInheritCheckbox($element);
        }

        $html .= $this->_renderHint($element);

        return $this->_decorateRowHtml($element, $html);
    }

    protected function _renderDiffHtml(AbstractElement $element)
    {
        $html = '';

        // get path, scope and scope id
        $path = $this->_getPathByName($element->getData('name'));
        $scope = $element->getData('scope');
        $scopeId = $element->getData('scope_id');

        /** @var $collection Collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('path', $path);
        $collection->addFieldToFilter('scope', $scope);

        // if it is not default scope add scope id filter to the collection
        if($scope !== 'default'){
            $collection->addFieldToFilter('scope_id', $scopeId);
            // get current website/store code
//            $configData = Mage::getSingleton('adminhtml/config_data');
//            $website = $configData->getWebsite();
//            $store = $configData->getStore();
//            if($store === ''){
//                // Website
//                $collection->addFieldToFilter('code', $website);
//            } else {
//                // Store
//                $collection->addFieldToFilter('code', $store);
//            }
        }

        // if an entry was found and has data, add the diff html
        /** @var $entry DiffConfig */
        $entry = $collection->getFirstItem();
        if (count($entry->getData()) > 0) {
            $html .= '<td class="sync">';
            $html .=    '<button class="sync-config" onclick="replaceConfig(this)" type="button">';
            $html .=        '<div class="action-sync"></div>';
            $html .=    '</button>';
            $html .= '</td>';
            $html .= '<td class="value">';
            $html .=    '<div class="edit-diff-content">';
            $html .= $this->_getDiffElementHtml($element, $entry->getDiffValueRemote());
            $html .=    '</div>';
            $html .=    '<div class="diff-hidden">';
            $html .=        '<div class="path">';
            $html .= $path;
            $html .=        '</div>';
            $html .=        '<div class="scope">';
            $html .= $scope;
            $html .=        '</div>';
            $html .=        '<div class="scope-id">';
            $html .= $scopeId;
            $html .=        '</div>';
            $html .=        '<div class="update-url">';
            $html .= ''; // TODO: Insert sync url
            $html .=        '</div>';
            $html .=    '</div>';
            $html .= '</td>';
        }
        return $html;
    }

    /**
     * The only way to get the path is by the name of the element (i.e. groups[unsecure][fields][base_media_url][value])
     * Magento does not provide the path at this point
     *
     * @param string $name
     * @return string
     */
    protected function _getPathByName($name)
    {
        $path = '';
        $name = explode("[", $name);
        $path .= $this->getRequest()->getParam('section');
        $path .= '/' . substr_replace($name[1] ,"",-1);
        $path .= '/' . substr_replace($name[3] ,"",-1);
        return $path;
    }

    /**
     * Returns the element html rendered with the config value of the other system
     * Also deletes the id and name attribute
     *
     * @param AbstractElement $element
     * @param $value
     * @return mixed|string
     */
    protected function _getDiffElementHtml(AbstractElement $element, $value)
    {
        if($element->getRenderer() instanceof Regexceptions){
            $value = unserialize($value);
        }

        // set the value of the remote system
        $element->setValue($value);

        // get the rendered html
        $html = $this->_getElementHtml($element);

        // adapt html
        $doc = new \DOMDocument();
        $doc->loadHTML(utf8_decode($html));

        // remove !DOCTYPE tag
        $doc->removeChild($doc->firstChild);

        // throw away the id and name attribute of the field html
        // to avoid changes made in this form field get saved on submit button click
        /* @var \DOMNode $node */
        foreach($doc->getElementsByTagName('input') as $node){
            if($node->hasAttribute('type') && $node->getAttribute('type') === 'hidden'){
                $node->parentNode->removeChild($node);
                continue;
            }
            $node->removeAttribute('id');
            $node->removeAttribute('name');
        }

        foreach($doc->getElementsByTagName('select') as $node){
            $node->removeAttribute('id');
            $node->removeAttribute('name');
        }

        foreach($doc->getElementsByTagName('textarea') as $node){
            $node->removeAttribute('id');
            $node->removeAttribute('name');
        }

        // get all script nodes as string to adapt them
        $script = '';
        foreach($doc->getElementsByTagName('script') as $node){
            $script .= $doc->saveHtml($node);
            $node->parentNode->removeChild($node);
        }

        // remove all id and name attributes inside the script
        $script = preg_replace('/id\="[^"]*"/', '', $script);
        $script = preg_replace('/name\="[^"]*"/', '', $script);

        // add the script at the end of the html
        $html = utf8_encode($doc->saveHTML()) . $script;

        // throw away html and body tags
        $html = str_replace(array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $html);

        return $html;
    }
}