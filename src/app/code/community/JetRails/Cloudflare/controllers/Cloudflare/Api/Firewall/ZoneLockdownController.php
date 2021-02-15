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
	class JetRails_Cloudflare_Cloudflare_Api_Firewall_ZoneLockdownController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This method takes in all the information that is necessary for
		 * creating a zone lockdown rule through the request parameters. It then
		 * asks the Cloudflare API model to create said zone lockdown rule.
		 * @return  void
		 */
		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_zoneLockdown");
			$response = $api->create (
				$this->_request->getParam ("description"),
				$this->_request->getParam ("urls"),
				$this->_request->getParam ("configurations"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("priority") ? intval ( $this->_request->getParam ("priority") ) : null
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in all the information that is necessary for
		 * editing a zone lockdown rule though the request parameters. It then
		 * asks the Cloudflare API model to update the values of the zone
		 * lockdown rule with the corresponding zone lockdown rule id.
		 * @return  void
		 */
		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_zoneLockdown");
			$response = $api->edit (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("description"),
				$this->_request->getParam ("urls"),
				$this->_request->getParam ("configurations"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("priority")
					? intval ( $this->_request->getParam ("priority") )
					: null
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action simply takes in a zone lockdown rule id and a state value
		 * though the request parameters. It then asks the Cloudflare API to
		 * update the state of the zone lockdown rule based on the passed
		 * corresponding id.
		 * @return  void
		 */
		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_zoneLockdown");
			$response = $api->edit (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("description"),
				$this->_request->getParam ("urls"),
				$this->_request->getParam ("configurations"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("priority")
					? intval ( $this->_request->getParam ("priority") )
					: null
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in a zone lockdown rule id through the request
		 * parameters. It then asks the Cloudflare API model to delete the zone
		 * lockdown rule with the corresponding zone lockdown rule id.
		 * @return  void
		 */
		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_zoneLockdown");
			$response = $api->delete ( $this->_request->getParam ("id") );
			return $this->_sendResponse ( $response );
		}

	}
