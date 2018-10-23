<?php
/*
 * project          :   Pseudo router by Ulutas Dilhan
 * licence          :   CC BY-NC-SA 4.0 (https://creativecommons.org/licenses/by-nc-sa/4.0/)
 * contact          :   dilhan@systemstatus.fr
 * installation     :   Put this file into your project root path and configure "APP_URL" constant
 *
 * needed structure :   `-- inc
 *						 |-- layouts
 *						 |   |-- footer.php
 *						 |   `-- header.php
 *						 `-- views
 *						     |-- error.php
 *						     `-- home.php
 */


ob_start(); //prevent the "header already sent" error
session_start(); //launch session

//===============================================================
//                      Configuration
//===============================================================
// Your website url
const APP_URL = ""; //                                                           <-- DEFINE YOUR APP URL here (e.g. http://mywebsite.com)

// The views directory
const VIEWS_DIRECTORY = "inc/views";

// The layouts directory
const LAYOUTS_DIRECTORY = "inc/layouts";

// The default view (in case of undefined view by GET method)
const DEFAULT_PAGE = "home";

// Debug mode
const DEBUG_MODE = FALSE;

// The autoloader if necessary
const ALLOW_AUTOLOADER = FALSE;

//===============================================================
//                        Load resources
//===============================================================
if (ALLOW_AUTOLOADER)
	spl_autoload_register(function ($class) {
		include 'inc/class/' . $class . '.php';
	});

if (DEBUG_MODE){
	error_reporting(30719);
	var_dump($_GET);
	echo "<br>";
	var_dump($_POST);
}

//===============================================================
//            Check requested view in VIEWS_DIRECTORY
//===============================================================
$views = scandir(VIEWS_DIRECTORY);

if (isset($_GET[ 'view' ]) && !empty($_GET[ 'view' ])) {

	/*
	 *	Requested view isn't found in the views directory
	 *  => redirect to error view with 404 code
	 */
	if (!in_array($_GET[ 'view' ] . '.php', $views)) {

		header('Location: ' . APP_URL . '/error/404');
		exit;
	}else{
		$view = $_GET[ 'view' ];
	}

} else $view = DEFAULT_PAGE; // define default view

//===============================================================
//                      Generate view
//===============================================================
include LAYOUTS_DIRECTORY . "/header.php"; // link header
include VIEWS_DIRECTORY . "/" . $view . '.php'; // link view
include LAYOUTS_DIRECTORY . "/footer.php"; // link footer
unset($bdd); // for more performances