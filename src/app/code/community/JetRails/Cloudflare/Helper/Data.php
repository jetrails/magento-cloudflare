<?php

	/**
	 * This class is a helper class and it primarily deals with getting and
	 * setting the authentication email and token that is used to access the
	 * Cloudflare API. It also deals with loading all the domain names that are
	 * found within this Magento installation and which domain is currently
	 * selected.
	 * @version     1.0.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 */
	class JetRails_Cloudflare_Helper_Data extends Mage_Core_Helper_Abstract {

		/**
		 * @var     string       XPATH_SCOPE          Scope of config setting
		 * @var     string       XPATH_AUTH_EMAIL     Path to auth email setting
		 * @var     string       XPATH_AUTH_TOKEN     Path to auth token setting
		 */
		const XPATH_SCOPE = "default";
		const XPATH_AUTH_EMAIL = "cloudflare/configuration/auth_email";
		const XPATH_AUTH_TOKEN = "cloudflare/configuration/auth_token";

		/**
		 * This method gets the value for the authorization email and decrypts
		 * it. It then returns that result to the caller.
		 * @return  string                            CF Authorization email
		 */
		public function getAuthEmail () {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$email = strval ( $config->getNode (
				$prefix . self::XPATH_AUTH_EMAIL
			));
			return Mage::getSingleton ("core/encryption")->decrypt ( $email );
		}

		/**
		 * This method gets the value for the authorization token and decrypts
		 * it. It then returns that result to the caller.
		 * @return  string                            CF Authorization token
		 */
		public function getAuthToken () {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$token = strval ( $config->getNode (
				$prefix . self::XPATH_AUTH_TOKEN
			));
			return Mage::getSingleton ("core/encryption")->decrypt ( $token );
		}

		/**
		 * This method returns the currently selected domain name. If there is
		 * no domain name that is selected, then the main website's domain name
		 * is extracted from the store's base URL.
		 * @return  string                            Currently selected domain
		 */
		public function getDomainName () {
			$session = Mage::getSingleton ("admin/session");
			if ( !empty ( $session->getCloudflareSelectedDomain () ) ) {
				return $session->getCloudflareSelectedDomain ();
			}
			$domain = Mage::getBaseUrl ( Mage_Core_Model_Store::URL_TYPE_WEB );
			$domain = parse_url ( $domain ) ["host"];
			return $domain;
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
				return array (
					"name" => $domain,
					"active" => $domain == $selection,
					"action" => Mage::getUrl (
						"*/*/domain",
						array (
							"_query" => array ( "domain" => $domain )
						)
					)
				);
			}, $domains );
			return $domains;
		}

		/**
		 * This method takes in a new email, saves that email internally, and
		 * that email is then used for CF authentication.
		 * @param   string       email                Set CF auth email to this
		 */
		public function setAuthEmail ( $email ) {
			$email = trim ( strval ( $email ) );
			$email = Mage::getSingleton ("core/encryption")->encrypt ( $email );
			Mage::getConfig ()->saveConfig (
				self::XPATH_AUTH_EMAIL,
				$email,
				self::XPATH_SCOPE,
				0
			);
			Mage::app ()->getStore ()->resetConfig ();
		}

		/**
		 * This method takes in a new email, saves that token internally, and
		 * that token is then used for CF authentication.
		 * @param   string       token                Set CF auth token to this
		 */
		public function setAuthToken ( $token ) {
			$token = trim ( strval ( $token ) );
			$token = Mage::getSingleton ("core/encryption")->encrypt ( $token );
			Mage::getConfig ()->saveConfig (
				self::XPATH_AUTH_TOKEN,
				$token,
				self::XPATH_SCOPE,
				0
			);
			Mage::app ()->getStore ()->resetConfig ();
		}

	}
