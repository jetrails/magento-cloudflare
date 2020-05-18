<?php

	/**
	 * This block class is binded to every section template found in the design
	 * folder. This block class has methods that give the template access to a
	 * valid form key for AJAX communications. This block class also returns a
	 * custom endpoint for every section based on the binded template's path.
	 * @version     1.1.7
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Section
	extends Mage_Core_Block_Template {

		/**
		 * Uses core session model to return a valid form key. This form key is
		 * used to enable AJAX communications.
		 * @return  string                      Form key
		 */
		public function getFormKey () {
			return Mage::getSingleton ("core/session")->getFormKey ();
		}

		/**
		 * This method takes the template that is binded to this block and it
		 * uses the template name to generate a custom endpoint. This endpoint
		 * is used to enable AJAX communications with the template's
		 * respective controllers.
		 * @return  string                      URL to custom endpoint
		 */
		public function getApiEndpoint () {
			$route = $this->getTemplate ();
			$route = preg_replace ( "/^cloudflare\/|\.phtml$/", "", $route );
			$route = explode ( "/", $route );
			$route = array_map ( function ( $i ) {
				$i = explode ( "_", $i );
				$i = array_map ( "ucfirst", $i );
				$i [ 0 ] = strtolower ( $i [ 0 ] );
				$i = implode ( "", $i );
				return $i;
			}, $route );
			$route = implode ( "_", $route );
			return Mage::getUrl ("adminhtml/cloudflare_api_$route");
		}

	}
