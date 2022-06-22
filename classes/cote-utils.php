<?php

if (!defined("ABSPATH")) { exit;}

if (!class_exists("COTE_Utils")) {
	class COTE_Utils {
		const AUTOSERVICES_DB_TABLE_NAME = 'cote_autoservices';
		const AUTOSERVICE_TO_REGION_DB_TABLE_NAME = 'cote_autoservice_to_region';
		const REGIONS_DB_TABLE_NAME = 'cote_regions';
		// usually I'm using const if its value used more than once
	    const API_URL = "http://pony.codevery.work:8450";

		public static function loadWidget() {
			register_widget('COTE_Widget');

			return true;
		}

		public static function registerWidget() {
			try {
				add_action('widgets_init', array("COTE_Utils", 'loadWidget'));

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function getWidgetLayouts() {
            $layout = array(
                'title' => 'Choose Index',
                'image' => '',
            );

            return $layout;
		}

		public static function getWidgetStyle($layout, $bonusClass = '') {
			try {
				$result = '<style>'
				          .'.widget_cote_widget {'
				          .'box-shadow: 0px 9px 28px 8px rgba(103, 119, 134, 0.05), 0px 6px 16px rgba(103, 119, 134, 0.08), 0px 3px 6px -4px rgba(103, 119, 134, 0.12) !important;'
				          .'width: auto !important;'
				          .'}'
				          .'.footer-wrapper .widget_cote_widget, .footer-widget.widget_cote_widget {'
				          .'background-color: transparent !important;'
				          .'padding: 0px !important;'
				          .'box-shadow: none !important;'
				          .'width: auto !important;'
				          .'}'
				          .'.cote-widget:not(.cote-footer-link) {'
				          .'display: flex;'
				          .'flex-direction: column;'
				          .'overflow: hidden;'
				          .'background: #FFFFFF;'
				          .'border-radius: 10px;'
				          .'color: black;'
				          .'}'
				          .'.cote-widget .section-header {'
				          .'background-color: transparent;'
				          .'padding: 0;'
				          .'border: 0;'
				          .'}'
				          .'.cote-widget .widget-title, .cote-widget .widget-header, .cote-widget .sidebar-widget-title {'
				          .'color: black !important;'
				          .'margin: 15px !important;'
				          .'font-style: normal;'
				          .'font-weight: 600;'
				          .'font-size: 18px;'
				          .'line-height: 23px;'
				          .'background: white;'
				          .'padding: 0 !important;'
				          .'text-align: left;'
				          .'text-transform: none;'
				          .'border: none !important;'
				          .'}'
				          .'.cote-widget .widget-title:before, .cote-widget .widget-title:after {'
				          .'display: none !important;'
				          .'}'
				          .'.cote-widget .cote-widget-image {'
				          .'width: 100%;'
				          .'display: block;'
				          .'}'
				          .'.cote-widget:not(.cote-footer-link) .cote-widget-button1 {'
				          .'margin: 15px !important;'
				          .'margin-top: 0px !important;'
				          .'font-weight: 600;'
				          .'text-decoration: none;'
				          .'line-height: 29px;'
				          .'background: #FFFFFF;'
				          .'border-radius: 5px;'
				          .'outline: 0;'
				          .'border: 0;'
				          .'min-height: 40px;'
				          .'padding: 0;'
				          .'color: '.$layout['buttonTextColor'].';'
				          .'display: block;'
				          .'transition: .2s;'
				          .'text-shadow: none;'
				          .'cursor: pointer;'
				          .'}'
				          .'.cote-widget:not(.cote-footer-link) .cote-widget-button1.cote-widget-button-bordered {'
				          .'border: 1px solid #3761EA;'
				          .'}'
				          .'.cote-widget:not(.cote-footer-link) .cote-widget-button1.cote-widget-button-shadowed {'
				          .'box-shadow: 0px 0px 10px rgba(205, 212, 222, 0.5);'
				          .'white-space: nowrap;'
				          .'}'
				          .'.cote-widget:not(.cote-footer-link) .cote-widget-button1:hover {'
				          .'background: '.$layout['buttonTextColor'].';'
				          .'color: #ffffff;'
				          .'}'
				          .'</style>';

				return $result;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			return '';
		}

		public static function createDbTables($wpdb, $wpPrefix) {
			try {
				$tableCreateCodes = [
					"cote_autoservices" =>
"CREATE TABLE `".esc_sql($wpPrefix.self::AUTOSERVICES_DB_TABLE_NAME)."` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`franchise_id` INT(10) NOT NULL,
	`franchise_name` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`phone` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`website` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`email` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`images` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `franchise_id` (`franchise_id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;",
					"cote_autoservice_to_region" =>
"CREATE TABLE `".esc_sql($wpPrefix.self::AUTOSERVICE_TO_REGION_DB_TABLE_NAME)."` (
	`franchise_id` INT(10) NOT NULL,
	`region_code` INT(10) NOT NULL,
	INDEX `region_code` (`region_code`) USING BTREE,
	UNIQUE INDEX `franchise_id` (`franchise_id`, `region_code`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;",
					"cote_regions" =>
"CREATE TABLE `".esc_sql($wpPrefix.self::REGIONS_DB_TABLE_NAME)."` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`postal_code` INT(10) NOT NULL,
	`region_code` INT(10) NOT NULL,
	`city` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`state` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`region` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `region_code` (`postal_code`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;",
				];

				foreach ($tableCreateCodes as $tName => $tCode) {
					$checkStatTable = $wpdb->get_var('SHOW TABLES LIKE "'.esc_sql($wpPrefix.$tName).'"');
					if (empty($checkStatTable)) {
						require_once (ABSPATH."/wp-admin/includes/upgrade.php");
						$tableCreateResult = dbDelta($tCode, true);
						if (empty($tableCreateResult)) {
							$creationError = true;
						}
					}
				}
				unset($tName,$tCode);

				if (!empty($creationError)) {
				    throw new Exception('1 or more tables are not created');
                }

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function removeDbTables() {
			try {
				global $wpdb;
				if (empty($wpdb)) {
					throw new Exception("wpdb doesn't exists");
				}

				$wpPrefix = self::getWpPrefix();

				$tableRemoveCodes = [
					"cote_autoservices" =>
						"DROP TABLE IF EXISTS `".esc_sql($wpPrefix.self::AUTOSERVICES_DB_TABLE_NAME)."`;",
					"cote_autoservice_to_region" =>
						"DROP TABLE IF EXISTS `".esc_sql($wpPrefix.self::AUTOSERVICE_TO_REGION_DB_TABLE_NAME)."`;",
					"cote_regions" =>
						"DROP TABLE IF EXISTS `".esc_sql($wpPrefix.self::REGIONS_DB_TABLE_NAME)."`;",
				];

				foreach ($tableRemoveCodes as $tName => $tCode) {
                    require_once (ABSPATH."/wp-admin/includes/upgrade.php");
                    $wpdb->query($tCode);
				}
				unset($tName,$tCode);

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
        }

		public static function getWpPrefix() {
			$wpPrefix = '';

            if (!empty($GLOBALS['wpPrefix'])) {
                $wpPrefix = $GLOBALS['wpPrefix'];
            } elseif (!empty($GLOBALS['table_prefix'])) {
                $wpPrefix = $GLOBALS['table_prefix'];
            }

			return $wpPrefix;
		}

		public static function ajaxGetWidgetData($tunnelData) {
			try {
				if (!empty($_POST['type'])&&$_POST['type']=='getWidgetData') {
					$tableCheckResult = self::syncToApi();
					if (empty($tableCheckResult)) {
						wp_die($tunnelData);
                    }
					global $wpdb;
					$wpPrefix = self::getWpPrefix();

					$queryString = $wpdb->prepare(
'SELECT WCR.postal_code, WCR.region_code, WCR.city, WCR.state, WCR.region, WCATR.franchise_id, WCA.franchise_name, WCA.phone, WCA.website, WCA.email, WCA.images
FROM '.$wpPrefix.self::REGIONS_DB_TABLE_NAME.' WCR
LEFT JOIN '.$wpPrefix.self::AUTOSERVICE_TO_REGION_DB_TABLE_NAME.' WCATR ON WCATR.region_code = WCR.region_code
LEFT JOIN '.$wpPrefix.self::AUTOSERVICES_DB_TABLE_NAME.' WCA ON WCA.franchise_id = WCATR.franchise_id
WHERE WCATR.franchise_id IS NOT NULL
ORDER BY WCR.postal_code, WCA.franchise_name'
                    );

					$getResult = $wpdb->get_results($queryString, ARRAY_A);

					$tunnelData = json_encode($getResult);
//					$tunnelData = $getResult;
				}
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			wp_die($tunnelData);
//			return false;
		}

		public static function syncToApi() {
			try {
				$syncCd = get_transient('coteSyncCd');
				if (!empty($syncCd)) {
				    return true;
				}

				global $wpdb;
				if (empty($wpdb)) {
					throw new Exception("wpdb doesn't exists");
				}

				$wpPrefix = self::getWpPrefix();

				$checkTables = self::createDbTables($wpdb, $wpPrefix);
				if (empty($checkTables)) {
					return false;
				}

				$requestArgs = [
					'headers' => [
						'Api-Key' => 548979832057758973
					],
					'sslverify' => false,
					'timeout' => 15
				];

				$requestResult = wp_remote_get(self::API_URL, $requestArgs);
				if (empty($requestResult)||empty($requestResult['body'])) {
					throw new Exception("api request body is empty");
				}

				$decodedRequestResult = json_decode($requestResult['body'], true);
				if (empty($decodedRequestResult)||($decodedRequestResult["success"] == false)) {
					throw new Exception("api request status not success");
				}

				$autoServiceQuery = '';
				$autoServiceToRegionQuery = '';
				$counter = 0;
				$counter2 = 0;
				$autoServiceQuery .= "INSERT INTO ".$wpPrefix.self::AUTOSERVICES_DB_TABLE_NAME." (franchise_id, franchise_name, phone, website, email, images) VALUES ";
				$autoServiceToRegionQuery .= "INSERT IGNORE INTO ".$wpPrefix.self::AUTOSERVICE_TO_REGION_DB_TABLE_NAME." (franchise_id, region_code) VALUES ";
				foreach ($decodedRequestResult['auto_service'] as $item) {
					$counter ++;
					$autoServiceQuery .= ($counter != 1 ?", ":"")."(".(int) sanitize_text_field($item['franchise_id']).",'".sanitize_text_field($item['franchise_name'])."','".sanitize_text_field($item['phone'])."','".sanitize_text_field($item['website'])."','".sanitize_text_field($item['email'])."','".self::API_URL.sanitize_text_field($item['images'])."')";

					$regionalCodes = explode(",", $item['region_codes']);
					if (!empty($regionalCodes)) {
						foreach ($regionalCodes as $regionCode) {
							$counter2 ++;
							$autoServiceToRegionQuery .= ($counter2 != 1 ?", ":"")."(".(int) sanitize_text_field($item['franchise_id']).",".(int) sanitize_text_field($regionCode).")";
						}
						unset($regionCode);
					}
				}
				unset($item, $counter, $counter2);
				$autoServiceQuery .= " ON DUPLICATE KEY UPDATE franchise_id = values(franchise_id), franchise_name = values(franchise_name), phone = values(phone), website = values(website), email = values(email), images = values(images) ";
//				$autoServiceToRegionQuery .= " ON DUPLICATE KEY UPDATE franchise_id = values(franchise_id), region_code = values(region_code) ";
				$wpdb->query($autoServiceQuery);
				$wpdb->query($autoServiceToRegionQuery);

				$regionQuery = '';
				$counter = 0;
				$regionQuery .= "INSERT INTO ".$wpPrefix.self::REGIONS_DB_TABLE_NAME." (postal_code, region_code, city, state, region) VALUES ";
				foreach ($decodedRequestResult['region_mappings_string'] as $item) {
					$counter ++;
					$regionQuery .= ($counter != 1 ?", ":"")."(".(int) sanitize_text_field($item['postal_code']).",".(int) sanitize_text_field($item['region_code']).",'".sanitize_text_field($item['city'])."','".sanitize_text_field($item['state'])."','".sanitize_text_field($item['region'])."')";
				}
				unset($item, $counter);
				$regionQuery .= " ON DUPLICATE KEY UPDATE postal_code = values(postal_code), region_code = values(region_code), city = values(city), state = values(state), region = values(region) ";
				$wpdb->query($regionQuery);

				set_transient('coteSyncCd', 1, 60*10);
				wp_cache_flush();
//				foreach ($decodedRequestResult['auto_service'] as $item) {
//			        $dataForUpdate = [
//				        "franchise_id" => $item["franchise_id"],
//			            "franchise_name"=> $item["franchise_name"],
//			            "phone"=> $item["phone"],
//			            "website"=> $item["website"],
//			            "email"=> $item["email"],
//			            "images"=> $item["images"]
//			        ];
//
//					$updateResult = $wpdb->update( $wpPrefix.'cote_autoservices', $dataForUpdate,
//						['franchise_id' => $item["franchise_id"]]);
//
//					if (!empty($updateResult)&&is_int($updateResult)) {
//						$regionalCodes = explode(",", $item['region_codes']);
//						if (!empty($regionalCodes)) {
//							foreach ($decodedRequestResult['auto_service'] as $regionCode) {
//								$updateResult = $wpdb->update( $wpPrefix.'cote_autoservices', $dataForUpdate,
//									['franchise_id' => $item["franchise_id"]]);
//							}
//							unset($regionCode);
//						}
//					}
//				}
//				unset($item);
//
//				foreach ($decodedRequestResult['region_mappings_string'] as $item) {
//					$dataForUpdate = [
//						"postal_code" => $item["postal_code"],
//						"region_code"=> $item["region_code"],
//						"city"=> $item["city"],
//						"state"=> $item["state"],
//						"region"=> $item["region"],
//					];
//
//					$updateResult = $wpdb->update( $wpPrefix.'cote_autoservices', $dataForUpdate,
//						['region_code' => $item["region_code"]]);
//
//				}
//				unset($item);

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function registerJsCss() {
			try {
				wp_enqueue_script(
					'cote-js-functions',
					COTE_PLUGIN_URL.'assets/js/cote-js-functions.js',
					array('jquery'),
					"1.0"
				);

				wp_enqueue_style(
					'cote-widget-css',
					COTE_PLUGIN_URL.'assets/css/cote-widget-css.css',
					array(),
					"1.0"
				);

//				wp_enqueue_script(
//					'cote-js-functions',
//					'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
//					array('jquery'),
//					"1.0"
//				);
//
//				wp_enqueue_style(
//					'cote-widget-css',
//					'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
//					array(),
//					"1.0"
//				);

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function registerAjaxUrl() {
			try {
				$ajaxurl = admin_url('admin-ajax.php');
				if (empty($ajaxurl)) {
					return false;
				}
				?><script>if (typeof cote_ajaxurl==='undefined') {var cote_ajaxurl = '<?php echo $ajaxurl ?>';}</script><?php

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function scriptsToHeaderAdd() {
		    //unused
			?><link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /><?php
            ?><script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script><?php

            return true;
		}

		public static function fileGenerator($pathToFile) {
			try {
				$fileExists = file_exists($pathToFile);
				if (empty($fileExists)) {
					$createdFile = fopen($pathToFile, 'w');
					fclose($createdFile);

					$fileExists = file_exists($pathToFile);
					if (empty($fileExists)) {
						$errorText = basename($pathToFile)." file generation error";
						COTE_Logs::saveLogs('errors', $errorText);
					}
				}
				return $fileExists;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function pluginActivated() {
			try {
				COTE_Logs::generateFilePaths();
				self::syncToApi();
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}

		public static function pluginUninstalled() {
			// here
			try {
				self::removeDbTables();

				return true;
			}
			catch (Exception $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}
			catch (Error $ex) {
				$errorText = __FUNCTION__." error: ".$ex->getMessage();
				COTE_Logs::saveLogs('errors', $errorText);
			}

			return false;
		}


	}
}
