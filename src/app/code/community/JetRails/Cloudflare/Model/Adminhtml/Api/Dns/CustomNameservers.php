<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.2.2
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Dns_CustomNameservers
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 */
		protected $_endpoint = "";

		/**
		 * This method simply constructs a GET request to the endpoint that is
		 * most appropriate based on how this object was configured.
		 * @return  stdClass                          CF response to request
		 */
		public function getValue () {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ( $endpoint );
			if ( $response->success ) {
				$response->result = true
					&& property_exists ( $response->result, "vanity_name_servers_ips" )
					&& $response->result->vanity_name_servers_ips
					? $response->result->vanity_name_servers_ips
					: new stdClass ();
			}
			return $response;
		}

		/**
		 * This method takes in a list of custom nameservers and it updates it
		 * accordingly using Cloudflare's API.
		 * @param   array        records              List of custom nameservers
		 * @return  stdClass                          CF response to request
		 */
		public function edit ( $records ) {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array ( "vanity_name_servers" => $records ));
			$response = $api->resolve ( $endpoint );
			if ( $response->success ) {
				$response->result = $response->result->vanity_name_servers_ips
					? $response->result->vanity_name_servers_ips
					: new stdClass ();
			}
			return $response;
		}

	}
