<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_UserAgentBlocking
	extends Mage_Core_Model_Abstract {

		public function load ( $page = 1, $previous = array () ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/firewall/ua_rules", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$api->setQuery ( "page", intval ( $page ) );
			$result = $api->resolve ( $endpoint );
			if ( property_exists ( $result, "result_info" ) && property_exists ( $result->result_info, "per_page" ) && property_exists ( $result->result_info, "total_count" ) ) {
				if ( $page < ceil ( $result->result_info->total_count / $result->result_info->per_page ) ) {
					$previous = array_merge ( $previous, $result->result );
					return $this->load ( $page + 1, $previous );
				}
				else {
					$result->result = array_merge ( $previous, $result->result );
				}
			}
			$result->usage = $this->usage ();
			return $result;
		}

		public function delete ( $id ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/firewall/ua_rules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		public function update ( $id, $mode, $paused, $value, $description ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/firewall/ua_rules/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PUT );
			$api->setData ( array (
				"configuration" => array (
					"target" => "ua",
					"value" => $value
				),
				"id" => $id,
				"mode" => $mode,
				"paused" => $paused,
				"description" => $description
			));
			return $api->resolve ( $endpoint );
		}

		public function create ( $mode, $paused, $value, $description ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/firewall/ua_rules", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setData ( array (
				"configuration" => array (
					"target" => "ua",
					"value" => $value
				),
				"mode" => $mode,
				"paused" => $paused,
				"description" => $description
			));
			return $api->resolve ( $endpoint );
		}

		public function usage () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/firewall/ua_rules/usage", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$result = $api->resolve ( $endpoint );
			$result = array_filter ( $result->result, function ( $i ) {
				return $i->scope === "zone";
			});
			return $result [ 0 ];
		}

	}
