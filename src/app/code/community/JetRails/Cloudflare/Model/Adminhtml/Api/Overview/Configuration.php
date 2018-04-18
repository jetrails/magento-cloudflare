<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Overview_Configuration extends Mage_Core_Model_Abstract {

		protected function _getCachedZoneId ( $domain ) {
			$hitTable = Mage::getSingleton ("core/session")->getZoneIdHitTable ();
			if ( empty ( $lookupTable ) ) $hitTable = array ();
			if ( array_key_exists ( "$domain", $hitTable ) === false ) {
				$hitTable [ "$domain" ] = array ( "hits" => 0, "total" => 0 );
			}
			$hitTable [ "$domain" ] [ "total" ] = $hitTable [ "$domain" ] [ "total" ] + 1;
			$lookupTable = Mage::getSingleton ("core/session")->getZoneIdLookupTable ();
			if ( !empty ( $lookupTable ) && array_key_exists ( "$domain", $lookupTable ) ) {
				$hitTable [ "$domain" ] [ "hits" ] = $hitTable [ "$domain" ] [ "hits" ] + 1;
				Mage::getSingleton ("core/session")->setZoneIdHitTable ( $hitTable );
				return $lookupTable [ "$domain" ];
			}
			Mage::getSingleton ("core/session")->setZoneIdHitTable ( $hitTable );
			return false;
		}

		protected function _cacheZoneId ( $domain, $id ) {
			$lookupTable = Mage::getSingleton ("core/session")->getZoneIdLookupTable ();
			if ( empty ( $lookupTable ) ) $lookupTable = array ();
			$lookupTable [ "$domain" ] = $id;
			Mage::getSingleton ("core/session")->setZoneIdLookupTable ( $lookupTable );
		}

		public function validateAuth ( $email = null, $token = null ) {
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			if ( !empty ( $email ) && !empty ( $token ) ) {
				$api->setAuth ( $email, $token );
			}
			$response = $api->resolve ("zones");
			return $response->success;
		}

		public function getZoneId () {
			$data = Mage::helper ("cloudflare/data");
			$domain = $data->getDomainName ();
			if ( ( $cachedValue = $this->_getCachedZoneId ( $domain ) ) ) {
				return $cachedValue;
			}
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$api->setQuery ( "name", $domain );
			$response = $api->resolve ("zones");
 			if ( $response->success && count ( $response->result ) > 0 ) {
				$this->_cacheZoneId ( $domain, $response->result [ 0 ]->id );
				return $response->result [ 0 ]->id;
			}
			return null;
		}



	}
