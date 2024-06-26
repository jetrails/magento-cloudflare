<?php

	/**
	 * This class inherits from the PageGetter class, so loading of the initial
	 * values gets processed through the parent class.
	 * @version     1.3.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_AccessRules
	extends JetRails_Cloudflare_Model_Adminhtml_Api_PageGetter {

		/**
		 * @var     string       _endpoint            Postfixed to zone endpoint
		 */
		protected $_endpoint = "firewall/access_rules/rules";

		/**
		 * This method takes in an access rule id and asks the Cloudflare API to
		 * delete the rule that corresponds to that id.
		 * @param   string       id                  Access rule id
		 * @return  stdClass                         CF response to request
		 */
		public function deleteEntry ( $id ) {
			$endpoint = $this->getEndpoint ("firewall/access_rules/rules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in all the information necessary to create an
		 * access rule.
		 * @param   string       target              The target URL
		 * @param   string       value               The value for the target
		 * @param   boolean      mode                Is the rule active?
		 * @param   string       notes               Notes associated with rule
		 * @return  stdClass                         CF response to request
		 */
		public function add ( $target, $value, $mode, $notes ) {
			$endpoint = $this->getEndpoint ("firewall/access_rules/rules");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setPayload ( array (
				"mode" => $mode,
				"configuration" => array (
					"target" => $target,
					"value" => $value
				),
				"notes" => $notes
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in a new mode and an access rule it. It then asks
		 * the Cloudflare API to change the mode based on what we passed.
		 * @param   string       id                  Access rule id
		 * @param   boolean      mode                Is the rule active?
		 * @return  stdClass                         CF response to request
		 */
		public function updateMode ( $id, $mode ) {
			$endpoint = $this->getEndpoint ("firewall/access_rules/rules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array (
				"mode" => $mode
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in an access rule id and a note that is associated
		 * with it. It then asks the Cloudflare API to change the note to the
		 * one that is passed.
		 * @param   string       id                  Access rule id
		 * @param   string       notes               Access rule note
		 * @return  stdClass                         CF response to request
		 */
		public function updateNote ( $id, $notes ) {
			$endpoint = $this->getEndpoint ("firewall/access_rules/rules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array (
				"notes" => $notes
			));
			return $api->resolve ( $endpoint );
		}

	}
