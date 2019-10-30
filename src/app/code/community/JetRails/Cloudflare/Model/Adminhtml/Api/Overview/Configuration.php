<?php

	/**
	 * This class handles the logic to authenticate a zone/token pair through
	 * the use of the Cloudflare API.
	 * @version     1.1.3
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Overview_Configuration
	extends Mage_Core_Model_Abstract {

		/**
		 * This method takes in a zone and a token. It then makes an API call to
		 * Cloudflare and finds out if the supplied token for the zone is valid.
		 * @param   string       zone                CF authentication zone
		 * @param   string       token               CF authentication token
		 * @return  boolean                          Is user authenticated?
		 */
		public function validateAuth ( $zone = null, $token = null ) {
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ("user/tokens/verify");
			if ( !$response->success ) {
				return false;
			}
			if ( !$zone ) $zone = $this->getZoneId ();
			$response = $api->resolve ("zones/$zone");
			return $response->success;
		}

		/**
		 * This method is public facing and is used to return the zone id of the
		 * currently selected domain. We cache the domain and zone id pair
		 * internally because this method is used a lot throughout the module.
		 * @return  mixed                            Zone id or null if invalid
		 */
		public function getZoneId () {
			$data = Mage::helper ("cloudflare/data");
			return $data->getAuthZone ();
		}

	}
