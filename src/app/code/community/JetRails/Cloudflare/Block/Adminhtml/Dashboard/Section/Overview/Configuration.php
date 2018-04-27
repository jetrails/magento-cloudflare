<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Section_Overview_Configuration extends JetRails_Cloudflare_Block_Adminhtml_Dashboard_Section {

		public $state = "";

		public $messages = [""];

		public function getSaveEndpoint () {
			return Mage::getUrl ("cloudflare/dashboard/save");
		}

		public function getAuthEmail () {
			$email = Mage::helper ("cloudflare/data")->getAuthEmail ();
			return empty ( $email ) ? "" : $email;
		}

		public function getValidationState () {
			$data = Mage::helper ("cloudflare/data");
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			$email = $data->getAuthEmail ();
			$token = $data->getAuthToken ();
			return $api->validateAuth ( $email, $token ) ? "Valid" : "Invalid";
		}

		public function getZoneId () {
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			$response = $api->getZoneId ();
			return $response === false ? "N/A" : $response;
		}

	}
