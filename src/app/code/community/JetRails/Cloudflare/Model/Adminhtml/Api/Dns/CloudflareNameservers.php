<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.3.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Dns_CloudflareNameservers
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 */
		protected $_endpoint = "";

		/**
		 * This method overrides the parent method because it wraps the method
		 * in order to only return the information that is relevant. The
		 * nameservers that Cloudflare uses are defined within the metadata that
		 * is returned for all the zone settings. All this information is not
		 * relevant, so only the nameservers are returned.
		 * @return  stdClass                          Cloudflare API response
		 */
		public function getValue () {
			$response = parent::getValue ();
			if ( isset ( $response->success ) && $response->success ) {
				$response->result = $response->result->name_servers;
			}
			return $response;
		}

	}
