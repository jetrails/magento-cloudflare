<?php

	/**
	 * This block class is binded to the dashboard template. It contains helper
	 * methods that load and render tab contents. It also contains methods that
	 * help determine if the current store is configured with the supplied
	 * Cloudflare account.
	 * @version     1.2.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Block_Adminhtml_Dashboard
	extends Mage_Core_Block_Template {

		/**
		 * This method takes in a tab name and loads that tab's template binded
		 * to the tab block. The HTML is then returned to the caller.
		 * @param   string            name            Name of tab to load
		 * @return  string                            Loaded tab HTML
		 */
		public function getTabContent ( $name ) {
			return $this->getLayout ()
				->createBlock ("cloudflare/dashboard_tab")
				->setTemplate ("cloudflare/$name.phtml")
				->toHtml ();
		}

		/**
		 * This method uses this module's helper class to return the current
		 * store's domain name.
		 * @return  string                            Domain name of store
		 */
		public function getDomainName () {
			$data = Mage::helper ("cloudflare/data");
			$domain = $data->getDomainName ();
			return $domain;
		}

		/**
		 * This method uses this module's helper class to return all the domains
		 * that are contained within this Magento installation.
		 * @return  array                             All store domains
		 */
		public function getDomainNames () {
			$data = Mage::helper ("cloudflare/data");
			$domains = $data->getDomainNames ();
			return $domains;
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
