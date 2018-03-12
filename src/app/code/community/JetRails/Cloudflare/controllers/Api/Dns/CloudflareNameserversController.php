<?php

	class JetRails_Cloudflare_Api_Dns_CloudflareNameserversController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/dns/cloudflare_nameservers");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_dns_cloudflareNameservers");
			$response = $api->getNameservers ();
			return $this->_formatAndSend ( $response );
		}

	}
