<?php

	class JetRails_Cloudflare_Api_Speed_MirageController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/speed/mirage");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_mirage");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_speed_mirage");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
