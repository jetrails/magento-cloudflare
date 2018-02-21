<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Overview_Configuration extends Mage_Core_Model_Abstract {

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

			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$api->setQuery ( "name", $domain );
			$response = $api->resolve ("zones");
 			if ( $response->success && count ( $response->result ) > 0 ) {
				return $response->result [ 0 ]->id;
			}
			return null;
		}



	}
