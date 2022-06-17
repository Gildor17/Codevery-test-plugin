<?php

if (!defined("ABSPATH")) { exit;}

if (!class_exists("COTE_FranchiseSearch")) {
	class COTE_FranchiseSearch {
		/**
		 * @param $franchises_string string
		 * @param $region_mappings_string string
		 */

		function initialize(string $franchises_string, string $region_mappings_string) : void {
			// Assign $region_mappings
			// Assign $franchises

		}

		/**
		 * Should return an ordered array (by name) of franchises for this postal code with all their information
		 * @param $postal_code integer
		 * @return array
		 */

		function search(int $postal_code) : array {
			// Postal code 14410 should find 3 locations.
			// If sorted alphabetically, second location name is "Prohaska, Gibson and Rolfson"
			// website: auto-service.co/yw-159-d
			// city: Adams Basin
			// state: NY
			// Should return array of arrays

			return array();
		}
	}
}
