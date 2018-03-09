<?php

	class JetRails_Cloudflare_Api_Dns_CloudflareNameserversController extends JetRails_Cloudflare_Controller_ApiAction {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/dns/cloudflare_nameservers");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_dns_cloudflarenameservers");
			$response = $api->getNameservers ();
			return $this->_formatAndSend ( $response );
		}

	}
