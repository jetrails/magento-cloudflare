<?php

	class JetRails_Cloudflare_Controller_Action extends Mage_Adminhtml_Controller_Action {

		protected $_request;

		public function _construct () {
			$this->_request = $this->getRequest ();
		}

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare");
		}

		protected function _sendResponse ( $response, $encode = true ) {
			$this->getResponse ()
				->clearHeaders ()
				->setHeader ( "content-type", "application/json" );
			$this->getResponse ()
				->setBody ( $encode ? Mage::helper ("core")->jsonEncode ( $response ) : $response );
		}

		protected function _sendRaw ( $response ) {
			$this->getResponse ()
				->clearHeaders ()
				->setHeader ( "content-type", "application/octet-stream" );
			$this->getResponse ()
				->setBody ( $response );
		}

		protected function _format ( $response ) {
			$formatted = array ();
			$formatted [ "state" ] = $response->success ? "response_success" : "response_warning";
			$messages = array ();
			if ( $response->success ) {
				$messages = $response->messages;
			}
			else {
				foreach ( $response->errors as $error ) {
					array_push ( $messages, "Error $error->code: $error->message" );
					foreach ( $error->error_chain as $chained ) {
						array_push ( $messages, "Error $chained->code: $chained->message" );
					}
				}
			}
			$formatted ["messages"] = $messages;

			if ( count ( $response->messages ) == 0 && $response->success ) $formatted [ "messages" ] = [];
			$formatted [ "payload" ] = $response->result;
			return $formatted;
		}

		protected function _formatAndSend ( $response ) {
			$formatted = null;
			if ( is_array ( $response ) ) {
				$callback = $this->_format;
				$formatted = array_map ( function ( $i ) use ( $callback ) { return $this->_format ( $i ); }, $response );
			}
			else {
				$formatted = $this->_format ( $response );
			}
			$formatted = (array) $formatted;
			$formatted ["entitlements"] = $response->entitlements;
			$this->_sendResponse ( (object) $formatted );
		}

		public function indexAction () {
			$data = array (
				"state" => "",
				"messages" => [""],
				"payload" => false
			);
			$this->_sendResponse ( $data );
		}

	}
