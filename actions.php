<?php

if (!defined("ABSPATH")) {exit;}

try {
    if (empty(is_admin())&&empty(apply_filters('wp_doing_cron', defined('DOING_CRON')&&DOING_CRON))) {
	    add_action('wp_head', ['COTE_Utils', 'registerAjaxUrl']);
	    add_action('wp_enqueue_scripts', ['COTE_Utils', 'registerJsCss']);
    }

	// Register and load the widget
	COTE_Utils::registerWidget();

	add_action('wp_ajax_ajaxGetWidgetData', ['COTE_Utils', 'ajaxGetWidgetData']);
	add_action('wp_ajax_nopriv_ajaxGetWidgetData', ['COTE_Utils', 'ajaxGetWidgetData']);
	add_action('wp_head', ['COTE_Utils', 'scriptsToHeaderAdd']);
	COTE_Logs::generateFilePaths();

	if (!empty(apply_filters('wp_doing_cron', defined('DOING_CRON')&&DOING_CRON))) {
		COTE_Utils::syncToApi();
	}
}
catch (Exception $ex) {}
catch (Error $ex) {}