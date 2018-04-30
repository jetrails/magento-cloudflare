<?php

	class JetRails_Cloudflare_Api_ScrapeShield_HotlinkProtectionController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/scrape_shield/hotlink_protection");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_scrapeShield_hotlinkProtection");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_scrapeShield_hotlinkProtection");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
