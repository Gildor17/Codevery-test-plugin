<?php

if (!defined("ABSPATH")) { exit;}

/*
Plugin name:  Codevery test plugin
Description:  Codevery test plugin
Version:      1.0
Author:       Gildor
Author URI:   https://www.linkedin.com/in/sergiy-shkurenko-%F0%9F%87%BA%F0%9F%87%A6-4b8624190/
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
http://pony.codevery.work:8450/task.html
Ключ 548979832057758973
*/

//search still unfinished and css too
//choose place for widget in theme widget placing

require_once (ABSPATH."/wp-admin/includes/plugin.php");

include_once (dirname(__FILE__)."/classes/cote-utils.php");
include_once (dirname(__FILE__)."/classes/cote-franchise-search.php");
include_once (dirname(__FILE__)."/config.php");
include_once (dirname(__FILE__)."/classes/cote-widget.php");
include_once (dirname(__FILE__)."/actions.php");

try {
	return true;
}
catch (Exception $ex) {}
catch (Error $ex) {}