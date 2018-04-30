<?php

	class JetRails_Cloudflare_Api_ScrapeShield_EmailAddressObfuscationController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/scrape_shield/email_address_obfuscation");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_scrapeShield_emailAddressObfuscation");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_scrapeShield_emailAddressObfuscation");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
