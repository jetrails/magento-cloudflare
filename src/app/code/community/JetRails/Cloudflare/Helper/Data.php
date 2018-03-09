<?php

	class JetRails_Cloudflare_Helper_Data extends Mage_Core_Helper_Abstract {

		/**
		 * These constants are used to define the XPATH in the XML config file. These values define
		 * the custom configuration that this plugin has.
		 */
		const XPATH_SCOPE = "default";
		const XPATH_AUTH_EMAIL = "cloudflare/configuration/auth_email";
		const XPATH_AUTH_TOKEN = "cloudflare/configuration/auth_token";

		public function getAuthEmail () {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$email = strval ( $config->getNode ( $prefix . self::XPATH_AUTH_EMAIL ) );
			return Mage::getSingleton ("core/encryption")->decrypt ( $email );
		}

		public function getAuthToken () {
			$config = Mage::getConfig ();
			$prefix = self::XPATH_SCOPE . "/";
			$token = strval ( $config->getNode ( $prefix . self::XPATH_AUTH_TOKEN ) );
			return Mage::getSingleton ("core/encryption")->decrypt ( $token );
		}

		public function getDomainName () {
			$domain = Mage::getBaseUrl ( Mage_Core_Model_Store::URL_TYPE_WEB );
			$domain = parse_url ( $domain ) ["host"];
			return $domain;
		}

		public function setAuthEmail ( $email ) {
			$email = trim ( strval ( $email ) );
			$email = Mage::getSingleton ("core/encryption")->encrypt ( $email );
			Mage::getConfig ()->saveConfig ( self::XPATH_AUTH_EMAIL, $email, self::XPATH_SCOPE, 0 );
			Mage::app ()->getStore ()->resetConfig ();
		}

		public function setAuthToken ( $token ) {
			$token = trim ( strval ( $token ) );
			$token = Mage::getSingleton ("core/encryption")->encrypt ( $token );
			Mage::getConfig ()->saveConfig ( self::XPATH_AUTH_TOKEN, $token, self::XPATH_SCOPE, 0 );
			Mage::app ()->getStore ()->resetConfig ();
		}

	}
