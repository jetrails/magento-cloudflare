<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard
	extends Mage_Core_Block_Template {

		public function getTabContent ( $name ) {
			return $this->getLayout ()
				->createBlock ("cloudflare/dashboard_tab")
				->setTemplate ("cloudflare/$name.phtml")
				->toHtml ();
		}

		public function getDomainName () {
			$data = Mage::helper ("cloudflare/data");
			$domain = $data->getDomainName ();
			return $domain;
		}

		public function isValidAuth () {
			$data = Mage::helper ("cloudflare/data");
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $api->validateAuth ();
		}

		public function isValidZone () {
			$data = Mage::helper ("cloudflare/data");
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $this->isValidAuth () && !empty ( $api->getZoneId () );
		}

	}
