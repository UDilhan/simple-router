<?php
/*
 * project          :   Simple router by Ulutas Dilhan
 * licence          :   CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
 * contact          :   dilhan@systemstatus.fr
 */


ob_start(); //prevent the "header already sent" error
session_start(); //launch session

//===============================================================
//                      Configuration
//===============================================================

define("APP_CONFIG", require("inc/config/config.php")); // <---- Edit this file for app configuration

//===============================================================
//                        Load resources
//===============================================================
if (APP_CONFIG['ALLOW_AUTOLOADER'])

	spl_autoload_register(function ($class) {
		include 'inc/class/' . $class . '.php';
	});

else if (APP_CONFIG['ALLOW_MCV_AUTOLOADER']) {
	spl_autoload_register(function ($class) {
		include 'inc/class/' . $class . '.php';
	});
	spl_autoload_register(function ($class) {
		include 'inc/controllers/' . $class . '.php';
	});
	spl_autoload_register(function ($class) {
		include 'inc/middlewares/' . $class . '.php';
	});
}

if (APP_CONFIG['DEBUG_MODE']){
	error_reporting(30719);
	var_dump($_GET);
	echo "<br>";
	var_dump($_POST);
}

if (APP_CONFIG[ 'LOAD_COMPOSER' ]) require '../../vendor/autoload.php';

//===============================================================
//            Check requested view in VIEWS_DIRECTORY
//===============================================================
$views = scandir(APP_CONFIG['VIEWS_DIRECTORY']);

if (isset($_GET[ 'view' ]) && !empty($_GET[ 'view' ]))

	/*
	 *	Requested view isn't found in the views directory
	 *  => redirect to error view with 404 code
	 */
	if (in_array($_GET[ 'view' ] . '.php', $views)) $view = $_GET[ 'view' ];
	else {
		header('Location: ' . APP_URL . '/error/404');
		exit;
	}


 else $view = APP_CONFIG['DEFAULT_PAGE']; // define default view

//===============================================================
//                      Generate view
//===============================================================
include APP_CONFIG['LAYOUTS_DIRECTORY'] . "/header.php"; // link header
include APP_CONFIG['VIEWS_DIRECTORY'] . "/" . $view . '.php'; // link view
include APP_CONFIG['LAYOUTS_DIRECTORY'] . "/footer.php"; // link footer