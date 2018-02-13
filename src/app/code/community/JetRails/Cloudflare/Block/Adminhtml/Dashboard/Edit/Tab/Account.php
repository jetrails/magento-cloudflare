<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Edit_Tab_Account extends Mage_Adminhtml_Block_Widget_Form {

	    protected function _prepareForm () {
				// Make a new form element
				$form = new Varien_Data_Form ();
				// Add a field-set to the form
				$fieldset = $form->addFieldset (
					"account_configuration",
					array ( "legend" => Mage::helper ("cloudflare")->__("Account Configuration") )
				);
				// Add all the fields to the field-set
				$fieldset->addField ( "label", "text", array (
					"name"      =>  "label",
					"label"     =>  Mage::helper ("cloudflare")->__("Label"),
					"note"      =>  Mage::helper ("cloudflare")->__("Note"),
					"required"  =>  true,
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
