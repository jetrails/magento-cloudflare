<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.2.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_PageRules_PageRulesController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This method takes in all the information that is necessary for
		 * creating a page rule through the request parameters. It then asks the
		 * Cloudflare API model to create said page rule.
		 * @return  void
		 */
		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_pageRules_pageRules");
			$response = $api->create (
				$this->_request->getParam ("target"),
				$this->_request->getParam ("actions"),
				$this->_request->getParam ("status") == "true",
				intval ( $this->_request->getParam ("priority") )
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in all the information that is necessary for
		 * editing a page rule though the request parameters. It then asks the
		 * Cloudflare API model to update the values of the page rule with the
		 * corresponding page rule id.
		 * @return  void
		 */
		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_pageRules_pageRules");
			$response = $api->edit (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("target"),
				$this->_request->getParam ("actions"),
				$this->_request->getParam ("status") == "true"
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action simply takes in a page rule id and a state value though
		 * the request parameters. It then asks the Cloudflare API to update the
		 * state of the page rule based on the passed corresponding id.
		 * @return  void
		 */
		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_pageRules_pageRules");
			$response = $api->toggle (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("state") == "true"
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in a page rule id through the request parameters.
		 * It then asks the Cloudflare API model to delete the page rule with
		 * the corresponding page rule id.
		 * @return  void
		 */
		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_pageRules_pageRules");
			$response = $api->delete ( $this->_request->getParam ("id") );
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in a priorities list and based on this list, it
		 * asks the Cloudflare API model to update the priority order of every
		 * page rule.
		 * @return  void
		 */
		public function priorityAction () {
			$api = Mage::getModel ("cloudflare/api_pageRules_pageRules");
			$response = $api->priority (
				$this->_request->getParam ("priorities")
			);
			return $this->_sendResponse ( $response );
		}

	}
