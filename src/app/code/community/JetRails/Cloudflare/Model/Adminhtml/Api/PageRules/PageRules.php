<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_PageRules_PageRules
	extends Mage_Core_Model_Abstract {

		public function load () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$result = (array) $api->resolve ( $endpoint );
			$result ["entitlements"] = $this->getEntitlements ();
			return (object) $result;
		}

		public function create ( $target, $actions, $status = true, $priority = 1 ) {
			foreach ( $actions as $index => $action ) {
				if ( $action ["id"] == "browser_cache_ttl" ) $actions [ $index ] ["value"] = intval ( $action ["value"] );
				if ( $action ["id"] == "edge_cache_ttl" ) $actions [ $index ] ["value"] = intval ( $action ["value"] );
				if ( $action ["id"] == "forwarding_url" ) $actions [ $index ] ["value"] ["status_code"] = intval ( $action ["value"] ["status_code"] );
			}
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
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
				"priority" => $priority,
				"status" => $status === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		public function edit ( $id, $target, $actions, $status = true ) {
			foreach ( $actions as $index => $action ) {
				if ( $action ["id"] == "browser_cache_ttl" ) $actions [ $index ] ["value"] = intval ( $action ["value"] );
				if ( $action ["id"] == "edge_cache_ttl" ) $actions [ $index ] ["value"] = intval ( $action ["value"] );
				if ( $action ["id"] == "forwarding_url" ) $actions [ $index ] ["value"] ["status_code"] = intval ( $action ["value"] ["status_code"] );
			}
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
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
				"status" => $status === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		public function toggle ( $id, $state ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array (
				"status" => $state === true ? "active" : "disabled"
			));
			return $api->resolve ( $endpoint );
		}

		public function delete ( $id ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		public function priority ( $priorites ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/pagerules/priorities", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PUT );
			$api->setData ( $priorites );
			return $api->resolve ( $endpoint );
		}

		public function getEntitlements () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/entitlements", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$result = $api->resolve ( $endpoint );
			return array_filter ( $result->result, function ( $i ) { return $i->id == "page_rules"; }) [0];
		}

	}
