<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Section extends Mage_Core_Block_Template {

		public function getFormKey () {
			return Mage::getSingleton ("core/session")->getFormKey ();
		}

		public function getApiEndpoint () {
			return Mage::getUrl ("cloudflare/api");
		}

	}
