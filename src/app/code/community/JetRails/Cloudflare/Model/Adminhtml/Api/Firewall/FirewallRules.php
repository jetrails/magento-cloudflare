<?php

	/**
	 * This class inherits from the PageGetter class, so loading of the initial
	 * values gets processed through the parent class.
	 * @version     1.3.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_FirewallRules
	extends JetRails_Cloudflare_Model_Adminhtml_Api_PageGetter {

		/**
		 * @var     string       _endpoint            Postfixed to zone endpoint
		 */
		protected $_endpoint = "firewall/rules";

		/**
		 * This method wraps the PageGetter class and adds the results of the
		 * usage endpoint.
		 * @param   integer      page                Current page number to get
		 * @param   array        previous            Collection of prev results
		 * @return  stdClass                         CF response to request
		 */
		public function getValue ( $page = 1, $previous = array () ) {
			$result = parent::getValue ( $page, $previous );
			$result->usage = $this->usage ();
			return $result;
		}

		/**
		 * This method takes in an firewall rule id and asks the Cloudflare API to
		 * delete the rule that corresponds to that id.
		 * @param   string       id                  Firewall rule id
		 * @return  stdClass                         CF response to request
		 */
		public function deleteEntry ( $id ) {
			$endpoint = $this->getEndpoint ("firewall/rules/$id");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in all the information necessary to create an
		 * firewall rule.
		 * @param   string        name               Rule description
		 * @param   string        expression         Rule expression
		 * @param   string        action             Rule action
		 * @param   int           priority           Rule priority
		 * @param   boolean       paused             Is the rule paused?
		 * @param   array<string> products           Products if action == bypass
		 * @return  stdClass                         CF response to request
		 */
		public function create ( $name, $expression, $action, $priority, $paused, $products ) {
			$endpoint = $this->getEndpoint ("filters");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setPayload ( array ( array (
				"expression" => $expression,
			)));
			$filter = $api->resolve ( $endpoint );
			if ( $filter && $filter->success ) {
				$endpoint = $this->getEndpoint ("firewall/rules");
				$api = Mage::getModel ("cloudflare/api_request");
				$api->setType ( $api::REQUEST_POST );
				$api->setPayload ( array ( array (
					"filter" => array ( "id" => $filter->result [0]->id ),
					"action" => $action,
					"description" => $name,
					"priority" => $priority,
					"products" => $products,
					"paused" => $paused
				)));
				return $api->resolve ( $endpoint );
			}
			return $filter;
		}

		/**
		 * This method takes in a new mode and an firewall rule it. It then asks
		 * the Cloudflare API to change the mode based on what we passed.
		 * @param   string        id                 Firewall rule id
		 * @param   string        name               Rule description
		 * @param   string        filterId           Filter expression id
		 * @param   string        filterExpression   Filter expression
		 * @param   string        action             Rule action
		 * @param   int           priority           Rule priority
		 * @param   boolean       paused             Is the rule paused?
		 * @param   array<string> products           Products if action == bypass
		 * @return  stdClass                         CF response to request
		 */
		public function update ( $id, $name, $filterId, $filterExpression, $action, $priority, $paused, $products ) {
			$endpoint = $this->getEndpoint ("filters");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PUT );
			$api->setPayload ( array ( array (
				"id" => $filterId,
				"expression" => $filterExpression
			)));
			$filter = $api->resolve ( $endpoint );
			if ( $filter && $filter->success ) {
				$endpoint = $this->getEndpoint ("firewall/rules");
				$api = Mage::getModel ("cloudflare/api_request");
				$api->setType ( $api::REQUEST_PUT );
				$api->setPayload ( array ( array (
					"id" => $id,
					"description" => $name,
					"paused" => $paused,
					"action" => $action,
					"priority" => $priority,
					"products" => $products,
					"filter" => array (
						"id" => $filterId,
						"expression" => $filterExpression
					)
				)));
				return $api->resolve ( $endpoint );
			}
			return $filter;
		}

		/**
		 * This method asks the Cloudflare API for the usage information as it
		 * pertains to firewall rules. It then only returns the allocation for
		 * the zone scope.
		 * @return  stdClass                         CF response to request
		 */
		public function usage () {
			$endpoint = $this->getEndpoint ("firewall/rules/usage");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$result = $api->resolve ( $endpoint );
			if ( isset ( $result->result ) ) {
				$result = array_filter ( $result->result, function ( $i ) {
					return $i->scope === "zone";
				});
				return $result [ 0 ];
			}
			return [
				"used" => 0,
				"max" => 0
			];
		}

	}
