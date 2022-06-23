<?php

	/**
	 * This block class is used for tab template files. These template files
	 * use this block's helper methods in order to render all the sections that
	 * belong to said tab.
	 * @version     1.3.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Tab
	extends Mage_Core_Block_Template {

		/**
		 * This method takes in a target resource and checks if the session is
		 * authorized to use said resource. The target is postfixed to the
		 * jetrails/cloudflare ACL resource path.
		 * @var     string            target          Resource to check
		 * @return  boolean                           Is session authorized?
		 */
		public function isAllowed ( $target ) {
			return Mage::getSingleton ("admin/session")
				->isAllowed ("jetrails/cloudflare/$target");
		}

		/**
		 * This method takes in a section category (which tab it appears in) and
		 * the section name. Based on the passed information, it returns the
		 * HTML of the section after binding the respective template to the
		 * generic section block.
		 * @param   string            category        Section category
		 * @param   string            name            Section Name
		 * @return  string                            HTML of section
		 */
		public function loadSection ( $category, $name ) {
			$category = preg_replace ( "/\/.*/", "", $category );
			return $this->getLayout ()
				->createBlock ("cloudflare/dashboard_section")
				->setTemplate ("cloudflare/$category/$name.phtml")
				->toHtml ();
		}

		/**
		 * This method takes in the tab name and the sections to render within
		 * the given tab. This method then authenticates the user and determines
		 * if said user is allowed to see the contents of that section. If
		 * resource is restricted, then the user does not see it. If all
		 * sections are restricted, then the user is shown a message informing
		 * them that the whole section is restricted.
		 * @param   string            name            The name of the tab
		 * @param   array             sections        The sections to render
		 * @return  string                            HTML for all sections
		 */
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

		/**
		 * This method uses the overview/configuration model to determine
		 * whether the API credentials that are saved internally are valid.
		 * @return  boolean                           Are API credentials valid?
		 */
		public function isValidAuth () {
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $api->validateAuth ();
		}

		/**
		 * This method uses the overview/configuration model to determine
		 * whether or not the current store's domain is configured within
		 * Cloudflare and whether or not there is a zone associated with that
		 * domain.
		 * @return  boolean                           Zone exists for domain?
		 */
		public function isValidZone () {
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			return $this->isValidAuth () && !empty ( $api->getZoneId () );
		}

	}
