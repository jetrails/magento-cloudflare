<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.2.5
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_MobileRedirect
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 */
		protected $_endpoint = "settings/mobile_redirect";

		/**
		 * This method contacts the Cloudflare API and asks for the current
		 * value for the setting but also returns domain name options.
		 * @return  stdClass                          CF response to request
		 */
		public function getValue () {
			$apiMobileRedirect = Mage::getModel ("cloudflare/api_request");
			$apiMobileRedirect->setType ( $apiMobileRedirect::REQUEST_GET );
			$setting = $apiMobileRedirect->resolve ( $this->getEndpoint () );
			if ( isset ( $setting->success ) && $setting->success ) {
				$apiDomains = Mage::getModel ("cloudflare/api_request");
				$apiDomains->setType ( $apiDomains::REQUEST_GET );
				$apiDomains->setQuery ( "per_page", 1000 );
				$apiDomains->setQuery ( "name", "starts_with:" );
				$apiDomains->setQuery ( "type", "A,AAAA,CNAME" );
				$domains = $apiDomains->resolve ( $this->getEndpoint ("dns_records") );
				$setting->result->domains = array_map ( function ( $domain ) {
					preg_match ( "/^(.*)\..*?\..*$/m", $domain->name, $match );
					return array (
						"value" => count ( $match ) > 1 ? $match [ 1 ] : "",
						"label" => $domain->name . " (" . $domain->type . ")",
					);
				}, $domains->result );
			}
			return $setting;
		}

		/**
		 * This method takes in the options as arguments and transforms that
		 * into a valid request.
		 * @param   string      mobileSubdomain       Subdomain to use
		 * @param   string      status                Expecting 'on' or 'off'
		 * @param   boolean     stripUri              Drop path or keep it?
		 * @return  stdClass                          CF response to request
		 */
		public function change ( $mobileSubdomain, $status, $stripUri ) {
			$data = array (
				"mobile_subdomain" => $mobileSubdomain,
				"status" => $status,
				"strip_uri" => $stripUri
			);
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array ( "value" => $data ) );
			$response = $api->resolve ( $endpoint );
			return $response;
		}

	}
