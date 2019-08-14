<?php

	/**
	 * This class handles the logic to authenticate a zone/token pair through
	 * the use of the Cloudflare API.
	 * @version     1.1.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Overview_Configuration
	extends Mage_Core_Model_Abstract {

		/**
		 * This method caches a zone value based on a passed domain. This is
		 * used cache the result of an API call within an entire session. The
		 * zone id is cached, because it gets used a lot throughout a typical
		 * session.
		 * @param   string       domain               Domain to cache as key
		 * @param   string       zone                 The zone to cache as value
		 * @return  void
		 */
		protected function _setCached ( $domain, $zone ) {
			$session = Mage::getSingleton ("core/session");
			$lookup = array ();
			if ( !empty ( $session->getDomainZone () ) ) {
				$lookup = $session->getDomainZone ();
			}
			$lookup [ "$domain" ] = "$zone";
			$session->setDomainZone ( $lookup );
		}

		/**
		 * This method attempts to retrieve a zone id from cache, based on a
		 * domain name. If there is no zone id for the passed domain name, then
		 * false is returned.
		 * @param   string       domain               Domain for zone id
		 * @return  mixed                             Cached zone id or false
		 */
		protected function _getCached ( $domain ) {
			$session = Mage::getSingleton ("core/session");
			$lookup = $session->getDomainZone ();
			if ( !empty ( $lookup )
				 && is_array ( $lookup )
				 && array_key_exists ( "$domain", $lookup ) ) {
				return $lookup ["$domain"];
			}
			return false;
		}

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
			$domain = $data->getDomainName ();
			$cached = $this->_getCached ("$domain");
			if ( $cached !== false ) {
				return $cached;
			}
			$zone = $data->getAuthZone ();
			$this->_setCached ( "$domain", $zone );
			return $zone;
		}

	}
