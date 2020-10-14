<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.2.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Dns_DnsRecordsController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action looks at the DNS record id that is passed though the
		 * request parameters and it asks the Cloudflare API model to delete the
		 * record with said id.
		 * @return  void
		 */
		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$response = $api->deleteRecord ( $this->_request->getParam ("id") );
			return $this->_sendResponse ( $response );
		}

		/**
		 * This method takes in all necessary information to create a DNS record
		 * and it sanitizes the data as much as it can. It then asks the
		 * Cloudflare API model to create said record.
		 * @return  void
		 */
		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$response = $api->createRecord (
				trim ( strtoupper ( $this->_request->getParam ("type") ) ),
				trim ( $this->_request->getParam ("name") ),
				trim ( $this->_request->getParam ("content") ),
				intval ( $this->_request->getParam ("ttl") ),
				$this->_request->getParam ("proxied") == "true",
				intval ( $this->_request->getParam ("priority") )
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in all values that are required to edit a DNS
		 * record and it asks the Cloudflare API model to change it based on the
		 * id that is passed through the request parameters.
		 * @return  void
		 */
		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$response = $api->editRecord (
				$this->_request->getParam ("id"),
				trim ( strtoupper ( $this->_request->getParam ("type") ) ),
				$this->_request->getParam ("name"),
				$this->_request->getParam ("content"),
				intval ( $this->_request->getParam ("ttl") ),
				$this->_request->getParam ("proxied") == "true",
				intval ( $this->_request->getParam ("priority") )
			);
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action simply asks the Cloudflare API model for the bind config
		 * file based on the user's DNS configuration. This information is then
		 * returned to the visitor as raw binary data.
		 * @return  void
		 */
		public function exportAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			return $this->_sendRaw ( $api->export () );
		}

		/**
		 * This action takes in the uploaded bind config file and asks the
		 * Cloudflare API model to parse the file and add the DNS records that
		 * are contained within it.
		 * @return  void
		 */
		public function uploadAction () {
			$api = Mage::getModel ("cloudflare/api_dns_dnsRecords");
			$file = $_FILES ["file"] ["tmp_name"];
			if ( file_exists ( $file ) ) {
				$response = $api->import ( $_FILES ["file"] );
				return $this->_sendResponse ( $response, false );
			}
			else {
				return $this->_sendResponse ( array ( "success" => false ) );
			}
		}

	}
