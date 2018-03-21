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

		public function createRecord ( $type, $name, $content, $ttl, $proxied = null, $priority = 1 ) {
			$data = array (
				"type" => $type,
				"name" => $name,
				"content" => $content,
				"ttl" => $ttl,
				"priority" => $priority
			);
			if ( in_array ( $type, array ( "A", "AAAA", "CNAME" ) ) ) {
				$data ["proxied"] = $proxied;
			}
			if ( $type == "MX" ) {
				$data ["priority"] = $priority;
			}
			if ( $type == "LOC" && preg_match ( "/^IN LOC ([^ ]+) ([^ ]+) ([^ ]+) ([NS]) ([^ ]+) ([^ ]+) ([^ ]+) ([WE]) ([^ ]+)m ([^ ]+)m ([^ ]+)m ([^ ]+)m$/", $content, $matches ) ) {
				$data ["data"] = array (
					"lat_degrees" => intval ( $matches [ 1 ] ),
					"lat_minutes" => intval ( $matches [ 2 ] ),
					"lat_seconds" => doubleval ( $matches [ 3 ] ),
					"lat_direction" => $matches [ 4 ],
					"long_degrees" => intval ( $matches [ 5 ] ),
					"long_minutes" => intval ( $matches [ 6 ] ),
					"long_seconds" => doubleval ( $matches [ 7 ] ),
					"long_direction" => $matches [ 8 ],
					"altitude" => intval ( $matches [ 9 ] ),
					"size" => intval ( $matches [ 10 ] ),
					"precision_horz" => intval ( $matches [ 11 ] ),
					"precision_vert" => intval ( $matches [ 12 ] )
				);
				$data ["priority"] = 1;
				$data ["proxied"] = false;
			}
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setData ( $data );
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
