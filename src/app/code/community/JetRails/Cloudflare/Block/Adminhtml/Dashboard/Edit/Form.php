<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Edit_Form
	extends Mage_Adminhtml_Block_Widget_Form {

	    protected function _prepareForm () {
	        $form = new Varien_Data_Form ( array (
	            "id" => "edit_form",
	            "method" => "post",
	            "enctype" => "multipart/form-data"
			));
	        $form->setUseContainer ( true );
	        $this->setForm ( $form );
	        return parent::_prepareForm ();
	    }

	}
