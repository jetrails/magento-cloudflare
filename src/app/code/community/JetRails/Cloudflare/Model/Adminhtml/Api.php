<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api extends Mage_Core_Model_Abstract {

		protected $_api;
		protected $_data;

		public function _construct () {
			$this->_api = Mage::helper ("cloudflare/api");
			$this->_data = Mage::helper ("cloudflare/data");
		}

		protected function _makeResponse ( $response, $payload = false ) {
			$error = false;
			if ( !$response->success ) {
				$error = array_map ( function ( $item ) {
					return sprintf ( "Error %i: %s", $item->code, $item->message );
				}, $response->errors );
			}
			return array (
				"error" => $error,
				"payload" => $payload
			);
		}

	}
