<?php

	class JetRails_Cloudflare_Api_ScrapeShield_ServerSideExcludesController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/scrape_shield/server_side_excludes");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_scrapeShield_serverSideExcludes");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_scrapeShield_serverSideExcludes");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
