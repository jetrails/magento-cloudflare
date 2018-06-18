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
				$counter = 0;
				foreach ( $sections as $section ) {
					if ( $this->isAllowed ("$name/$section") ) {
						echo $this->loadSection ( $name, $section );
						$counter++;
					}
				}
				if ( $counter === 0 ) {
					echo $this->loadSection ( "core", "empty" );
				}
			}
			else {
				echo $this->loadSection ( "core", "restricted" );
			}
		}

		public function isValidAuth () {
			$data = Mage::helper ("cloudflare/data");
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $api->validateAuth ();
		}

		public function isValidZone () {
			$data = Mage::helper ("cloudflare/data");
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $this->isValidAuth () && !empty ( $api->getZoneId () );
		}

	}
