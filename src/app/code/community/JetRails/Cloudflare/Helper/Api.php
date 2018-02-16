<?php

	class JetRails_Cloudflare_Helper_Api extends Mage_Core_Helper_Abstract {

		const CLOUDFLARE_API_ENDPOINT = "https://api.cloudflare.com/client/v4/";
		const REQUEST_GET = "GET";
		const REQUEST_DELETE = "DELETE";

		private $authEmail;
		private $authToken;

		public function __construct () {
			$data = Mage::helper ("cloudflare/data");
			$this->authEmail = $data->getAuthEmail ();
			$this->authToken = $data->getAuthToken ();
		}

		private function _getAuthHeaders () {
			return array (
				"X-Auth-Email" => $this->authEmail,
				"X-Auth-Key" => $this->authToken,
				"Content-Type" => "application/json"
			);
		}

		private function _createHeaders ( $payload ) {
			$authHeaders = $this->_getAuthHeaders ();
			$combined = array_merge ( $authHeaders, $payload );
			$headers = array ();
			array_walk ( $combined, function ( $value, $key ) use ( &$headers ) {
				array_push ( $headers, $key . ": " . $value );
			});
			return $headers;
		}

		private function _makeRequest ( $type, $endpoint, $params, $payload ) {
			$url = self::CLOUDFLARE_API_ENDPOINT . "$endpoint" . "?" . http_build_query ( $params );
			$handle = curl_init ();
			curl_setopt ( $handle, CURLOPT_URL, $url );
			curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $handle, CURLOPT_CUSTOMREQUEST, $type );
			curl_setopt ( $handle, CURLOPT_HTTPHEADER, $this->_createHeaders ( $payload ) );
			$result = curl_exec ( $handle );
			$responseCode = curl_getinfo ( $handle, CURLINFO_HTTP_CODE );
			curl_close ( $handle );
			return json_decode ( $result );
		}

		public function setAuth ( $email, $token ) {
			$this->authEmail = trim ( strval ( $email ) );
			$this->authToken = trim ( strval ( $token ) );
			return $this;
		}

		public function get ( $endpoint, $params = [], $payload = [] ) {
			return $this->_makeRequest ( self::REQUEST_GET, $endpoint, $params, $payload );
		}

	}
