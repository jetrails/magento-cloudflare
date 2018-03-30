<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_PageRules_PageRules extends Mage_Core_Model_Abstract {

		public function load () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function create ( $target, $actions, $status = true ) {
			foreach ( $actions as $index => $action ) {
				if ( $action ["id"] == "browser_cache_ttl" ) $actions [ $index ] ["value"] = intval ( $action ["value"] );
				if ( $action ["id"] == "edge_cache_ttl" ) $actions [ $index ] ["value"] = intval ( $action ["value"] );
				if ( $action ["id"] == "forwarding_url" ) $actions [ $index ] ["value"] ["status_code"] = intval ( $action ["value"] ["status_code"] );
			}
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setData ( array (
				"targets" => array (
					array (
						"target" => "url",
						"constraint" => array (
							"operator" => "matches",
							"value" => $target
						)
					)
				),
				"actions" => $actions,
				"priority" => 1,
				"status" => $status === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		public function toggle ( $id, $state ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array (
				"status" => $state === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		public function delete ( $id ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

	}
