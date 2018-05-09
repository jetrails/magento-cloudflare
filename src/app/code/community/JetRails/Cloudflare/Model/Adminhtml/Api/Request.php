<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Request extends Mage_Core_Model_Abstract {

		protected $_type;
		protected $_headers;
		protected $_data;
		protected $_query;

		const CLOUDFLARE_API_ENDPOINT = "https://api.cloudflare.com/client/v4/";
		const REQUEST_GET = "GET";
		const REQUEST_DELETE = "DELETE";
		const REQUEST_PUT = "PUT";
		const REQUEST_POST = "POST";
		const REQUEST_PATCH = "PATCH";

		public function _construct () {
			$this->_headers = false;
			$this->_data = false;
			$this->_query = false;
			$data = Mage::helper ("cloudflare/data");
			$this->setType ( self::REQUEST_GET );
			$this->setHeader ( "X-Auth-Email", $data->getAuthEmail () );
			$this->setHeader ( "X-Auth-Key", $data->getAuthToken () );
			$this->setHeader ( "Content-Type", "application/json" );
		}

		protected function _getEndpoint ( $target ) {
			$url = self::CLOUDFLARE_API_ENDPOINT . "/" . $target;
			if ( $this->_query !== false ) {
				$url .= "?" . http_build_query ( $this->_query );
			}
			return $url;
		}

		public function setAuth ( $email, $token ) {
			$this->setHeader ( "X-Auth-Email", $email );
			$this->setHeader ( "X-Auth-Key", $token );
		}

		public function setType ( $type ) {
			switch ( $type ) {
				case self::REQUEST_GET:
					$this->_type = self::REQUEST_GET;
					break;
				case self::REQUEST_DELETE:
					$this->_type = self::REQUEST_DELETE;
					break;
				case self::REQUEST_PUT:
					$this->_type = self::REQUEST_PUT;
					break;
				case self::REQUEST_POST:
					$this->_type = self::REQUEST_POST;
					break;
				case self::REQUEST_PATCH:
					$this->_type = self::REQUEST_PATCH;
					break;
			}
		}

		public function setHeader ( $key, $value ) {
			if ( $this->_headers === false ) $this->_headers = array ();
			$this->_headers [ strval ( $key ) ] = strval ( $value );
		}

		public function setData ( $value ) {
			$this->_data = $value;
		}

		public function setQuery ( $key, $value ) {
			if ( $this->_query === false ) $this->_query = array ();
			$this->_query [ strval ( $key ) ] = strval ( $value );
		}

		public function resolve ( $endpoint, $decode = true ) {
			$handle = curl_init ();
			curl_setopt ( $handle, CURLOPT_URL, $this->_getEndpoint ( $endpoint ) );
			curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $handle, CURLOPT_SAFE_UPLOAD, true );
			curl_setopt ( $handle, CURLOPT_CUSTOMREQUEST, $this->_type );
			if ( $this->_headers !== false ) {
				$headers = array ();
				array_walk ( $this->_headers, function ( $value, $key ) use ( &$headers ) {
					array_push ( $headers, $key . ": " . $value );
				});
				curl_setopt ( $handle, CURLOPT_HTTPHEADER, $headers );
			}
			if ( $this->_data !== false ) {
				$post_data = $this->_data;
				if ( $this->_headers ["Content-Type"] == "application/json" ) {
					$post_data = json_encode ( $this->_data );
				}
				curl_setopt ( $handle, CURLOPT_POSTFIELDS, $post_data );
			}
			$result = curl_exec ( $handle );
			curl_close ( $handle );
			return $decode === true ? json_decode ( $result ) : $result;
		}

	}
