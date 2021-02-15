<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.2.3
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Firewall_AccessRulesController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action takes in an access rule id through the request parameters
		 * and it then asks the Cloudflare API model to delete said access rule
		 * with the corresponding id.
		 * @return  void
		 */
		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->delete (
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
		public function addAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->add (
				$this->_request->getParam ("target"),
				$this->_request->getParam ("value"),
				$this->_request->getParam ("mode"),
				$this->_request->getParam ("note")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in an access rule id and a note through the request
		 * parameters. It then asks the Cloudflare API model to update the note.
		 * @return  void
		 */
		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->updateNote (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("note")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in an access rule id and a mode through the request
		 * parameters. It then asks the Cloudflare API model to update the mode.
		 * @return  void
		 */
		public function modeAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->updateMode (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("mode")
			);
			return $this->_sendResponse ( $response );
		}

	}
