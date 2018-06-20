<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Dns_DnsRecords
	extends Mage_Core_Model_Abstract {

		public function listRecords ( $page = 1, $previous = array () ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$api->setQuery ( "page", intval ( $page ) );
			$result = $api->resolve ( $endpoint );
			if ( property_exists ( $result, "result_info" ) && property_exists ( $result->result_info, "per_page" ) && property_exists ( $result->result_info, "total_count" ) ) {
				if ( $page < ceil ( $result->result_info->total_count / $result->result_info->per_page ) ) {
					$previous = array_merge ( $previous, $result->result );
					return $this->listRecords ( $page + 1, $previous );
				}
				else {
					$result->result = array_merge ( $previous, $result->result );
				}
			}
			return $result;
		}

		public function deleteRecord ( $id ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		public function editRecord ( $id, $type, $name, $content, $ttl, $proxied = null, $priority = 1 ) {
			if ( $name == "@" ) {
				$name = Mage::helper ("cloudflare/data")->getDomainName ();
			}
			$data = array (
				"type" => $type,
				"name" => $name,
				"content" => $content,
				"ttl" => $ttl,
				"priority" => $priority,
				"proxied" => $proxied
			);
			if ( in_array ( $type, array ( "A", "AAAA", "CNAME" ) ) ) {
				$data ["proxied"] = $proxied;
			}
			else if ( $type == "MX" ) {
				$data ["priority"] = $priority;
			}
			else if ( $type == "LOC" && preg_match ( "/^IN LOC ([^ ]+) ([^ ]+) ([^ ]+) ([NS]) ([^ ]+) ([^ ]+) ([^ ]+) ([WE]) ([^ ]+)m ([^ ]+)m ([^ ]+)m ([^ ]+)m$/", $content, $matches ) ) {
				$data ["data"] = array (
					"lat_degrees" => intval ( $matches [ 1 ] ),
					"lat_minutes" => intval ( $matches [ 2 ] ),
					"lat_seconds" => floatval ( $matches [ 3 ] ),
					"lat_direction" => $matches [ 4 ],
					"long_degrees" => intval ( $matches [ 5 ] ),
					"long_minutes" => intval ( $matches [ 6 ] ),
					"long_seconds" => floatval ( $matches [ 7 ] ),
					"long_direction" => $matches [ 8 ],
					"altitude" => intval ( $matches [ 9 ] ),
					"size" => intval ( $matches [ 10 ] ),
					"precision_horz" => intval ( $matches [ 11 ] ),
					"precision_vert" => intval ( $matches [ 12 ] )
				);
				$data ["priority"] = 1;
				$data ["proxied"] = false;
			}
			else if ( $type == "SRV" && preg_match ( "/^([^.]+)\.([^.]+)\.(.+)\.$/", $name, $matchesName ) && preg_match ( "/^SRV ([^ ]+) ([^ ]+) ([^ ]+) (.+)\.$/", $content, $matchesContent ) ) {
				if ( $matchesName [ 3 ] == "@" ) {
					$matchesName [ 3 ] = Mage::helper ("cloudflare/data")->getDomainName ();
				}
				if ( $matchesContent [ 4 ] == "@" ) {
					$matchesContent [ 4 ] = Mage::helper ("cloudflare/data")->getDomainName ();
				}
				$data ["data"] = array (
					"name" => $matchesName [ 3 ],
					"priority" => $matchesContent [ 1 ],
					"proto" => $matchesName [ 2 ],
					"weight" => $matchesContent [ 2 ],
					"port" => $matchesContent [ 3 ],
					"target" => $matchesContent [ 4 ],
					"service" => $matchesName [ 1 ]
				);
				$data ["priority"] = 1;
				$data ["proxied"] = false;
			}
			else if ( $type == "CAA" && preg_match ( "/^0 ((?:issue|issuewild|iodef)) \"(.+)\"$/", $content, $matches ) ) {
				$data ["data"] = array (
					"tag" => $matches [ 1 ],
					"value" => $matches [ 2 ],
					"flags" => 0
				);
				$data ["priority"] = 1;
				$data ["proxied"] = false;
			}
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records/%s", $zoneId, $id );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PUT );
			$api->setData ( $data );
			return $api->resolve ( $endpoint );
		}

		public function createRecord ( $type, $name, $content, $ttl, $proxied = null, $priority = 1 ) {
			if ( $name == "@" ) {
				$name = Mage::helper ("cloudflare/data")->getDomainName ();
			}
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
			else if ( $type == "MX" ) {
				$data ["priority"] = $priority;
			}
			else if ( $type == "LOC" && preg_match ( "/^IN LOC ([^ ]+) ([^ ]+) ([^ ]+) ([NS]) ([^ ]+) ([^ ]+) ([^ ]+) ([WE]) ([^ ]+)m ([^ ]+)m ([^ ]+)m ([^ ]+)m$/", $content, $matches ) ) {
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
			else if ( $type == "SRV" && preg_match ( "/^([^.]+)\.([^.]+)\.(.+)\.$/", $name, $matchesName ) && preg_match ( "/^SRV ([^ ]+) ([^ ]+) ([^ ]+) (.+)\.$/", $content, $matchesContent ) ) {
				if ( $matchesName [ 3 ] == "@" ) {
					$matchesName [ 3 ] = Mage::helper ("cloudflare/data")->getDomainName ();
				}
				if ( $matchesContent [ 4 ] == "@" ) {
					$matchesContent [ 4 ] = Mage::helper ("cloudflare/data")->getDomainName ();
				}
				$data ["data"] = array (
					"name" => $matchesName [ 3 ],
					"priority" => $matchesContent [ 1 ],
					"proto" => $matchesName [ 2 ],
					"weight" => $matchesContent [ 2 ],
					"port" => $matchesContent [ 3 ],
					"target" => $matchesContent [ 4 ],
					"service" => $matchesName [ 1 ]
				);
				$data ["priority"] = 1;
				$data ["proxied"] = false;
			}
			else if ( $type == "CAA" && preg_match ( "/^0 ((?:issue|issuewild|iodef)) \"(.+)\"$/", $content, $matches ) ) {
				$data ["data"] = array (
					"tag" => $matches [ 1 ],
					"value" => $matches [ 2 ],
					"flags" => 0
				);
				$data ["priority"] = 1;
				$data ["proxied"] = false;
			}
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setData ( $data );
			return $api->resolve ( $endpoint );
		}

		public function export () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records/export", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint, false );
		}

		public function import ( $file ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/dns_records/import", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setHeader ( "Content-Type", "multipart/form-data" );
			$api->setType ( $api::REQUEST_POST );
			$api->setData ( array (
				"file" => new CurlFile (
					$file ["tmp_name"],
					"text/plain",
					$file ["name"]
				)
			));
			return $api->resolve ( $endpoint, false );
		}

	}
