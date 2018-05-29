<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Section
	extends Mage_Core_Block_Template {

		public function getFormKey () {
			return Mage::getSingleton ("core/session")->getFormKey ();
		}

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
			return Mage::getUrl ("cloudflare/api_$route");
		}

	}
