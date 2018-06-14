<?php

	class JetRails_Cloudflare_Controller_Action
	extends Mage_Adminhtml_Controller_Action {

		protected $_request;

		public function _construct () {
			$this->_request = $this->getRequest ();
		}

		protected function _getResourceName () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$resource = str_replace ( "api_", "", $resource );
			$resource = str_replace ( "_", "/", $resource );
			$resource = preg_replace ( "/([A-Z])/", '_$1', $resource );
			return strtolower ( $resource );
		}

		protected function _isAllowed () {
			$resource = $this->_getResourceName ();
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/$resource");
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

	}
