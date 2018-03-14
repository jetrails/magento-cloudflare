<?php

	class JetRails_Cloudflare_Api_Dns_DnsRecordsController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/dns/dns_records");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$response = $api->listRecords ();
			return $this->_formatAndSend ( $response );
		}

		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$response = $api->deleteRecord ( $this->_request->getParam ("id") );
			return $this->_formatAndSend ( $response );
		}

		public function searchAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$response = $api->searchRecords ( trim ( $this->_request->getParam ("query") ) );
			return $this->_formatAndSend ( $response );
		}

	}
