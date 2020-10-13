<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.2.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_AutoMinify
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 */
		protected $_endpoint = "settings/minify";

		/**
		 * This method takes in boolean values that represent whether auto
		 * minification is turned on for js, css, and html. These values are
		 * then changed though Cloudflare's API.
		 * @param   boolean      js                   Is JS minification on?
		 * @param   boolean      css                  Is CSS minification on?
		 * @param   boolean      html                 Is HTML minification on?
		 * @return  stdClass                          CF response to request
		 */
		public function change ( $js, $css, $html ) {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => array (
				"js" => $js == "true" ? "on" : "off",
				"css" => $css == "true" ? "on" : "off",
				"html" => $html == "true" ? "on" : "off"
			)));
			return $api->resolve ( $endpoint );
		}

	}
