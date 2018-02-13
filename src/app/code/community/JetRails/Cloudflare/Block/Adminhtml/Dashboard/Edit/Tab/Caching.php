<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Edit_Tab_Caching extends Mage_Adminhtml_Block_Widget_Form {

	    protected function _prepareForm () {
				// Make a new form element
				$form = new Varien_Data_Form ();
				// Add a field-set to the form
				$purgeCacheFieldset = $form->addFieldset (
					"purge_cache",
					array ( "legend" => Mage::helper ("cloudflare")->__("Purge Cache") )
				);
				// Add all the fields to the field-set
				$purgeCacheFieldset->addField ( "purge_everything", "button", array (
					"name"      =>  "Purge Everything",
					"label"     =>  Mage::helper ("cloudflare")->__("Purge Everything"),
					"value"     =>  Mage::helper ("cloudflare")->__("Purge Everything"),
					"note"      =>  Mage::helper ("cloudflare")->__("Clear cached files to force Cloudflare to fetch a fresh version of those files from your web server. You can purge files selectively or all at once."),
					"class" 	=>  "form-button",
            		"onclick" 	=>  "setLocation('{$this->getUrl('*/*/submit')}')",
				));
				// Define form settings
				$form->setId ("caching");
				$form->setMethod ("post");
				$form->setUseContainer ( true );
				// Save the form internally and return the result of the inherited method
				$this->setForm ( $form );
				return parent::_prepareForm ();
	    }

	}
