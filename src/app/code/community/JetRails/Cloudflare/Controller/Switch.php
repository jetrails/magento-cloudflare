<?php

	class JetRails_Cloudflare_Controller_Switch
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$api = Mage::getModel ("cloudflare/$resource");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function toggleAction () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$api = Mage::getModel ("cloudflare/$resource");
			$state = $this->_request->getParam ("state");
			$response = $api->setValue ( $state === "true" );
			return $this->_sendResponse ( $response );
		}

	}
