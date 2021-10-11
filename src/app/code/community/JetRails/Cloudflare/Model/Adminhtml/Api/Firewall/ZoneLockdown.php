<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.2.6
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_ZoneLockdown
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 * @var     boolean     _usePatchToSet        Use PUT HTTP method
		 */
		protected $_endpoint = "firewall/lockdowns";
		protected $_usePatchToSet = false;

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
		 * to zone lockdown rules.
		 * @return  stdClass                          CF response to request
		 */
		public function getEntitlements () {
			$endpoint = $this->getEndpoint ("entitlements");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ( $endpoint );
			return current ( array_filter ( $response->result, function ( $i ) {
				return $i->id === "zonelockdown.max_rules";
			}));
		}

		/**
		 * This method takes in information about a zone lockdown and creates it
		 * using Cloudflare's API.
		 * @param   string       desc                 Zone lockdown description
		 * @param   array        urls                 Array of URLs to use
		 * @param   array        config               Mixtrure of IPs and IP Ranges
		 * @param   boolean      paused               Is it paused?
		 * @param   integer      priority             What is the priority, default: none
		 * @return  stdClass                          CF response to request
		 */
		public function create ( $desc, $urls, $config, $paused, $priority = null ) {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setPayload ( array (
				"description" => $desc,
				"urls" => $urls,
				"configurations" => $config,
				"paused" => $paused,
				"priority" => $priority
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in information about an already created zone
		 * lockdown and it updates it accordingly.
		 * using Cloudflare's API.
		 * @param   string       id                   Page rule ID
		 * @param   string       desc                 Zone lockdown description
		 * @param   array        urls                 Array of URLs to use
		 * @param   array        config               Mixtrure of IPs and IP Ranges
		 * @param   boolean      paused               Is it paused?
		 * @param   integer      priority             What is the priority, default: none
		 * @return  stdClass                          CF response to request
		 */
		public function edit ( $id, $desc, $urls, $config, $paused, $priority = null ) {
			$endpoint = $this->getEndpoint ( $this->_endpoint . "/$id" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $this->_usePatchToSet ? $api::REQUEST_PATCH : $api::REQUEST_PUT );
			$api->setPayload ( array (
				"description" => $desc,
				"urls" => $urls,
				"configurations" => $config,
				"paused" => $paused,
				"priority" => $priority
			));
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in a zone lockdown rule id and it attempts to
		 * delete it using the Cloudflare API.
		 * @param   string       id                   Page rule ID
		 * @return  stdClass                          CF response to request
		 */
		public function deleteEntry ( $id ) {
			$endpoint = $this->getEndpoint ( $this->_endpoint . "/$id" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

	}
