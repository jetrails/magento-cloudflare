<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

		/**
		 * This constructor is important because it defines what controller and block group this
		 * grid container will be using.  It then calls the super constructor to take care of the
		 * reset.
		 */
		public function __construct () {
			// Call the super constructor
			parent::__construct ();
			// Define the controller and block group
			$this->_objectId = "id";
			$this->_controller = "dashboard";
			$this->_blockGroup = "cloudflare";
			$this->_mode = "edit";
			// Remove buttons and update the save button text
			$this->_removeButton ("save");
			$this->_removeButton ("delete");
			$this->_removeButton ("back");
			$this->_removeButton ("reset");
		}

		/**
		 * This method simply defines the text that will be displayed above the form in the
		 * configure page.
		 * @return      string                                  Header text above form
		 */
		public function getHeaderText () {
			// Simply return the header text for the form
			$data = Mage::helper ("cloudflare/data");
			$domain = $data->getDomainName ();
			return $domain;
		}

	}
