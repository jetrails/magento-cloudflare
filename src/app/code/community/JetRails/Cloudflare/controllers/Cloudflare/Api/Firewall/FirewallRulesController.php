<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.2.7
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Firewall_FirewallRulesController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action takes in an access rule id through the request parameters
		 * and it then asks the Cloudflare API model to delete said access rule
		 * with the corresponding id.
		 * @return  void
		 */
		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_firewallRules");
			$response = $api->deleteEntry (
				$this->_request->getParam ("id")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in data that is necessary to create an access rule
		 * from the request parameters. It then asks the Cloudflare API to
		 * create said access rule.
		 * @return  void
		 */
		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_firewallRules");
			$response = $api->create (
				$this->_request->getParam ("name"),
				$this->_request->getParam ("expression"),
				$this->_request->getParam ("action"),
				$this->_request->getParam ("priority") == "" ? null : intval ( $this->_request->getParam ("priority") ),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("products")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in an access rule id and a note through the request
		 * parameters. It then asks the Cloudflare API model to update the note.
		 * @return  void
		 */
		public function updateAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_firewallRules");
			$response = $api->update (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("name"),
				$this->_request->getParam ("filterId"),
				$this->_request->getParam ("filterExpression"),
				$this->_request->getParam ("action"),
				$this->_request->getParam ("priority") == "" ? null : intval ( $this->_request->getParam ("priority") ),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("products")
			);
			return $this->_sendResponse ( $response );
		}

	}
