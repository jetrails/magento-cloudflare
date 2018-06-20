<?php

	class JetRails_Cloudflare_Controller_Update
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$api = Mage::getModel ("cloudflare/$resource");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function updateAction () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$api = Mage::getModel ("cloudflare/$resource");
			$value = $this->_request->getParam ("value");
			$response = $api->setValue ( $value );
			return $this->_sendResponse ( $response );
		}

	}
