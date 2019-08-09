<?php

	/**
	 * This class is a helper class and it primarily deals with getting and
	 * setting the authentication zone and token that is used to access the
	 * Cloudflare API. It also deals with loading all the domain names that are
	 * found within this Magento installation and which domain is currently
	 * selected.
	 * @version     1.1.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Helper_Data extends Mage_Core_Helper_Abstract {

		/**
		 * @var     string       XPATH_SCOPE          Scope of config setting
		 * @var     string       XPATH_AUTH_ZONE      Path to auth zone setting
		 * @var     string       XPATH_AUTH_TOKEN     Path to auth token setting
		 */
		const XPATH_SCOPE = "default";
		const XPATH_AUTH_ZONE = "cloudflare/configuration/auth_zone";
		const XPATH_AUTH_TOKEN = "cloudflare/configuration/auth_token";

		/**
		 * This method gets the value for the authorization zone and decrypts
		 * it. It then returns that result to the caller.
		 * @return  string                            CF Authorization zone
		 */
		public function getAuthZone () {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$zones = strval ( $config->getNode (
				$prefix . self::XPATH_AUTH_ZONE
			));
			if ( $zones ) {
				$zones = Mage::getSingleton ("core/encryption")
					->decrypt ( $zones );
				$zones = json_decode ( $zones );
				$domain = $this->getDomainName ();
				return $zones->$domain;
			}
			return null;
		}

		/**
		 * This method gets the value for the authorization token and decrypts
		 * it. It then returns that result to the caller.
		 * @return  string                            CF Authorization token
		 */
		public function getAuthToken () {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$tokens = strval ( $config->getNode (
				$prefix . self::XPATH_AUTH_TOKEN
			));
			if ( $tokens ) {
				$tokens = Mage::getSingleton ("core/encryption")
					->decrypt ( $tokens );
				$tokens = json_decode ( $tokens );
				$domain = $this->getDomainName ();
				return $tokens->$domain;
			}
			return null;
		}

		/**
		 * This method returns the currently selected domain name. If there is
		 * no domain name that is selected, then the main website's domain name
		 * is extracted from the store's base URL.
		 * @return  string                            Currently selected domain
		 */
		public function getDomainName () {
			$session = Mage::getSingleton ("core/session");
			if ( !empty ( $session->getCloudflareSelectedDomain () ) ) {
				return $session->getCloudflareSelectedDomain ();
			}
			$domain = Mage::getBaseUrl ( Mage_Core_Model_Store::URL_TYPE_WEB );
			$domain = parse_url ( $domain ) ["host"];
			preg_match ( "/\.?([^.]+\.[^.]+)$/i", $domain, $matches );
			return $matches [ 1 ];
		}

		/**
		 * This method looks though all the stores that are setup in Magento. It
		 * then extracts the domain name from the store's base URL. It then
		 * returns an array of objects that contain the domain name, the url for
		 * changing the selected domain to said domain, and whether the domain
		 * is currently selected.
		 * @return  array                             All domains for all stores
		 */
		public function getDomainNames () {
			$selection = $this->getDomainName ();
			$domains = array ();
			foreach ( Mage::app ()->getWebsites () as $website ) {
				foreach ( $website->getGroups () as $group ) {
					$stores = $group->getStores ();
					foreach ( $stores as $store ) {
						$domain = parse_url ( $store->getBaseUrl () ) ["host"];
						array_push ( $domains, $domain );
					}
				}
			}
			$domains = array_unique ( $domains );
			sort ( $domains );
			$domains = array_map ( function ( $domain ) use ( $selection ) {
				preg_match ( "/\.?([^.]+\.[^.]+)$/i", $domain, $matches );
				$domain = $matches [ 1 ];
				return array (
					"name" => $domain,
					"active" => $domain == $selection,
					"action" => Mage::helper ("adminhtml")->getUrl (
						"*/*/domain",
						array ( "name" => $domain )
					)
				);
			}, $domains );
			return $domains;
		}

		/**
		 * This method takes in a new zone, saves that zone internally, and
		 * that zone is then used for CF authentication.
		 * @param   string       zone                Set CF auth zone to this
		 */
		public function setAuthZone ( $zone ) {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$zones = strval ( $config->getNode (
				$prefix . self::XPATH_AUTH_ZONE
			));
			$map = (object) [];
			if ( $zones ) {
				$zones = Mage::getSingleton ("core/encryption")
					->decrypt ( $zones );
				$map = json_decode ( $zones );
			}
			$domain = $this->getDomainName ();
			$zone = trim ( strval ( $zone ) );
			$map->$domain = $zone;
			$map = json_encode ( $map );
			$map = Mage::getSingleton ("core/encryption")->encrypt ( $map );
			Mage::getConfig ()->saveConfig (
				self::XPATH_AUTH_ZONE,
				$map,
				self::XPATH_SCOPE,
				0
			);
			Mage::app ()->getStore ()->resetConfig ();
			Mage::app ()->getCacheInstance ()->cleanType ("config");
		}

		/**
		 * This method takes in a new token, saves that token internally, and
		 * that token is then used for CF authentication.
		 * @param   string       token                Set CF auth token to this
		 */
		public function setAuthToken ( $token ) {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$tokens = strval ( $config->getNode (
				$prefix . self::XPATH_AUTH_TOKEN
			));
			$map = (object) [];
			if ( $tokens ) {
				$tokens = Mage::getSingleton ("core/encryption")
					->decrypt ( $tokens );
				$map = json_decode ( $tokens );
			}
			$domain = $this->getDomainName ();
			$token = trim ( strval ( $token ) );
			$map->$domain = $token;
			$map = json_encode ( $map );
			$map = Mage::getSingleton ("core/encryption")->encrypt ( $map );
			Mage::getConfig ()->saveConfig (
				self::XPATH_AUTH_TOKEN,
				$map,
				self::XPATH_SCOPE,
				0
			);
			Mage::app ()->getStore ()->resetConfig ();
			Mage::app ()->getCacheInstance ()->cleanType ("config");
		}

	}
