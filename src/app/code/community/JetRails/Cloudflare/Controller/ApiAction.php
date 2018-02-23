<?php

	class JetRails_Cloudflare_Controller_ApiAction extends Mage_Adminhtml_Controller_Action {

		protected $_request;

		public function _construct () {
			$this->_request = $this->getRequest ();
		}

		/**
		 * This method simply asks Magento's ACL if the logged in user is allowed to see the
		 * configure page that belongs to this module.
		 * @return      boolean                                 Is the user allowed to see page?
		 */
		protected function _isAllowed () {
			// Is user allowed to manage 2FA accounts?
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare");
		}

		protected function _sendResponse ( $response ) {
			$this->getResponse ()
				->clearHeaders ()
				->setHeader ( "content-type", "application/json" );
			$this->getResponse ()
				->setBody ( Mage::helper ("core")->jsonEncode ( $response ) );
		}

		protected function _format ( $response ) {
			$formatted = array ();
			$formatted [ "state" ] = $response->success ? "response_success" : "response_warning";
			$formatted [ "messages" ] = $response->success ? $response->messages : array_map (
				function ( $message ) { return "Error $message->code: $message->message"; },
				$response->errors
			);
			if ( count ( $response->messages ) == 0 && $response->success ) $formatted [ "messages" ] = [ "Success" ];
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
			$this->_sendResponse ( $formatted );
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
