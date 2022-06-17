<?php

if (!defined("ABSPATH")) {exit;}

try {
    define('COTE_PLUGIN_PATH', dirname(__FILE__));
    define('COTE_PLUGIN_URL', plugin_dir_url(__FILE__));
    define('COTE_PLUGIN_DEV_MODE', false);

    // initiate plugin's global values
    if (!isset($GLOBALS['COTE_globals'])) {
        $GLOBALS['COTE_globals'] = [];
    }
}
catch (Exception $ex) {}
catch (Error $ex) {}