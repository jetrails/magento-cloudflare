<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.3.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Firewall_UserAgentBlockingController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action takes in a user agent rule id from the request parameters
		 * and it then asks the Cloudflare API model to delete said user agent
		 * rule with the cooresponding id.
		 * @return  void
		 */
		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->deleteEntry (
				$this->_request->getParam ("id")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in all the information that is necessary to create
		 * a user agent rule through the request parameters. It then asks the
		 * Cloudflare API model to create said user agent rule.
		 * @return  void
		 */
		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->create (
				$this->_request->getParam ("mode"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("value"),
				$this->_request->getParam ("description")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in all the information that is necessary to edit a
		 * user agent rule through the request parameters. It then asks the
		 * Cloudflare API model to edit said user agent rule based on the id
		 * that is passed.
		 * @return  void
		 */
		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->update (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("mode"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("value"),
				$this->_request->getParam ("description")
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action simply forwards to the edit action and returns the same
		 * response as the edit action.
		 * @return  void
		 */
		public function modeAction () {
			return $this->editAction ();
		}

		/**
		 * This action simply forwards to the edit action and returns the same
		 * response as the edit action.
		 * @return  void
		 */
		public function toggleAction () {
			return $this->editAction ();
		}

		/**
		 * This action simply forwards to the edit action and returns the same
		 * response as the edit action.
		 * @return  void
		 */
		public function pauseAction () {
			return $this->editAction ();
		}

	}
