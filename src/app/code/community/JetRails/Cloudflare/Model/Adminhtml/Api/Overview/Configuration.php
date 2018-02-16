<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Overview_Configuration extends JetRails_Cloudflare_Model_Adminhtml_Api {

		public function validateAuth ( $email = null, $token = null ) {
			if ( $email === null || $token === null ) {
				$data = Mage::helper ("cloudflare/data");
				$email = $data->getAuthEmail ();
				$token = $data->getAuthToken ();
			}
			$this->_api->setAuth ( $email, $token );
			$response = $this->_api->get ( "zones", [], [] );
			return $response->success;
		}

		public function getZoneId ( $domain = null ) {
			if ( $domain === null ) {
				$data = Mage::helper ("cloudflare/data");
				$domain = $data->getDomainName ();
			}
			$params = [ "name" => $domain ];
			$response = $this->_api->get ( "zones", $params, [] );
			return $response->success && count ( $response->result ) > 0 ? $response->result [ 0 ]->id : false;
		}

	}
