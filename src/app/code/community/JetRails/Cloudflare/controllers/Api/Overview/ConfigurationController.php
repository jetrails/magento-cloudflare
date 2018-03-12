<?php

	class JetRails_Cloudflare_Api_Overview_ConfigurationController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/overview/configuration");
		}

	}
