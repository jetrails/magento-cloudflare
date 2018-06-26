<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.0.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_PageRules_PageRules
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 */
		protected $_endpoint = "pagerules";

		/**
		 * This method wraps the parent method because we want to get the value
		 * that the parent returns and then append the entitlements result to
		 * it.
		 * @return  stdClass                          CF response to request
		 */
		public function getValue () {
			$result = (array) parent::getValue ();
			$result ["entitlements"] = $this->getEntitlements ();
			return (object) $result;
		}

		/**
		 * This method simply contacts the Cloudflare API and asks for a list of
		 * entitlements. It then only returns the entitlements that are related
		 * to page rules.
		 * @return  stdClass                          CF response to request
		 */
		public function getEntitlements () {
			$endpoint = $this->getEndpoint ("entitlements");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$result = $api->resolve ( $endpoint );
			return array_filter ( $result->result, function ( $i ) {
				return $i->id == "page_rules";
			}) [0];
		}

		/**
		 * This method takes in the target URL and the actions that should fire
		 * whenever the target is visited. It also takes in the status of the
		 * page rule and the priority that is associated with the page rule. It
		 * then contacts the Cloudflare API and creates the page rule.
		 * @param   string       target               Page rule target URL
		 * @param   array        actions              Settings for target
		 * @param   boolean      status               Is it enabled?
		 * @param   integer      priority             What is the priority
		 * @return  stdClass                          CF response to request
		 */
		public function create ( $target, $actions, $status = true, $priority = 1 ) {
			foreach ( $actions as $index => $action ) {
				if ( $action ["id"] == "browser_cache_ttl" ) {
					$actions [$index] ["value"] = intval ( $action ["value"] );
				}
				if ( $action ["id"] == "edge_cache_ttl" ) {
					$actions [$index] ["value"] = intval ( $action ["value"] );
				}
				if ( $action ["id"] == "forwarding_url" ) {
					$actions [$index] ["value"] ["status_code"] = intval (
						$action ["value"] ["status_code"]
					);
				}
			}
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setData ( array (
				"targets" => array (
					array (
						"target" => "url",
						"constraint" => array (
							"operator" => "matches",
							"value" => $target
						)
					)
				),
				"actions" => $actions,
				"priority" => $priority,
				"status" => $status === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in the target URL and the actions that should fire
		 * whenever the target is visited. It also takes in the status of the
		 * page rule as well as the page rule id that should be edited. It then
		 * contacts the Cloudflare API and edits the page rule with the
		 * corresponding id.
		 * @param   string       id                   Page rule ID
		 * @param   string       target               Page rule target URL
		 * @param   array        actions              Settings for target
		 * @param   boolean      status               Is it enabled?
		 * @return  stdClass                          CF response to request
		 */
		public function edit ( $id, $target, $actions, $status = true ) {
			foreach ( $actions as $index => $action ) {
				if ( $action ["id"] == "browser_cache_ttl" ) {
					$actions [$index] ["value"] = intval ( $action ["value"] );
				}
				if ( $action ["id"] == "edge_cache_ttl" ) {
					$actions [$index] ["value"] = intval ( $action ["value"] );
				}
				if ( $action ["id"] == "forwarding_url" ) {
					$actions [$index] ["value"] ["status_code"] = intval (
						$action ["value"] ["status_code"]
					);
				}
			}
			$endpoint = $this->getEndpoint ("pagerules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array (
				"targets" => array (
					array (
						"target" => "url",
						"constraint" => array (
							"operator" => "matches",
							"value" => $target
						)
					)
				),
				"actions" => $actions,
				"status" => $status === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in a page rule id and a state boolean. It then sets
		 * the page rule based on the passed state.
		 * @param   string       id                   Page rule ID
		 * @param   boolean      state                Is the page rule active?
		 * @return  stdClass                          CF response to request
		 */
		public function toggle ( $id, $state ) {
			$endpoint = $this->getEndpoint ("pagerules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array (
				"status" => $state === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in a page rule id and it attempts to delete it
		 * using the Cloudflare API.
		 * @param   string       id                   Page rule ID
		 * @return  stdClass                          CF response to request
		 */
		public function delete ( $id ) {
			$endpoint = $this->getEndpoint ("pagerules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in an array of page rules and their associated
		 * priority relative to one another. We use this priority to tell
		 * Cloudflare to change the priority of all the page rules.
		 * @param   array        priorities           Page rules in order
		 * @return  stdClass                          CF response to request
		 */
		public function priority ( $priorites ) {
			$endpoint = $this->getEndpoint ("pagerules/priorities");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PUT );
			$api->setData ( $priorites );
			return $api->resolve ( $endpoint );
		}

	}
