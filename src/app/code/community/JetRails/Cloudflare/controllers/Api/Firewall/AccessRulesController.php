<?php

	class JetRails_Cloudflare_Api_Firewall_AccessRulesController extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			return $this->_sendResponse ( array () );
		}

	}
