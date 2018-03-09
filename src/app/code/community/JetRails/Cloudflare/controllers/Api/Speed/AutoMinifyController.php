<?php

	class JetRails_Cloudflare_Api_Speed_AutoMinifyController extends JetRails_Cloudflare_Controller_ApiAction {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/speed/auto_minify");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_autominify");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_autominify");
			$response = $api->change (
				$this->_request->getParam ("js"),
				$this->_request->getParam ("css"),
				$this->_request->getParam ("html")
			);
			return $this->_formatAndSend ( $response );
		}

	}
