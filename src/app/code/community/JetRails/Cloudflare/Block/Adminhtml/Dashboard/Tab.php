<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Tab
	extends Mage_Core_Block_Template {

		public function isAllowed ( $target ) {
			return Mage::getSingleton ("admin/session")
				->isAllowed ("jetrails/cloudflare/$target");
		}

		public function loadSection ( $category, $name ) {
			$category = preg_replace ( "/\/.*/", "", $category );
			return $this->getLayout ()
				->createBlock ("cloudflare/dashboard_section")
				->setTemplate ("cloudflare/$category/$name.phtml")
				->toHtml ();
		}

		public function renderSections ( $name, $sections ) {
			if ( $this->isAllowed ("$name") ) {
				$html = "";
				$counter = 0;
				foreach ( $sections as $section ) {
					if ( $this->isAllowed ("$name/$section") ) {
						$html .= $this->loadSection ( $name, $section );
						$counter++;
					}
				}
				if ( $counter === 0 ) {
					return $this->loadSection ( "core", "empty" );
				}
				else {
					return $html;
				}
			}
			else {
				return $this->loadSection ( "core", "restricted" );
			}
		}

		public function isValidAuth () {
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $api->validateAuth ();
		}

		public function isValidZone () {
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $this->isValidAuth () && !empty ( $api->getZoneId () );
		}

	}
