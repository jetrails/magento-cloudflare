<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Dns_DnsRecords extends Mage_Core_Model_Abstract {

		public function listRecords () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function deleteRecord ( $id ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		public function searchRecords ( $query ) {
			$original = $query;
			$domain = Mage::helper ("cloudflare/data")->getDomainName ();
			if ( !preg_match ( "/" . preg_quote ( $domain ) . "$/i", $query ) && !empty ( $query ) ) $query .= ".$domain";
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			if ( !empty ( $query ) ) {
				$api->setQuery ( "name", "$query" );
				$api->setQuery ( "content", "$original" );
				$api->setQuery ( "match", "any" );
			}
			return $api->resolve ( $endpoint );
		}

	}
