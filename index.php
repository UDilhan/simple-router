<?php
/*
 * project          :   Simple router by Ulutas Dilhan
 * licence          :   MIT
 * contact          :   dilhan@systemstatus.fr
 */

/*
			MIT License

			Copyright (c) 2019 ULUTAS Dilhan

			Permission is hereby granted, free of charge, to any person obtaining a copy
			of this software and associated documentation files (the "Software"), to deal
			in the Software without restriction, including without limitation the rights
			to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
			copies of the Software, and to permit persons to whom the Software is
			furnished to do so, subject to the following conditions:

			The above copyright notice and this permission notice shall be included in all
			copies or substantial portions of the Software.

			THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
			IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
			FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
			AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
			LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
			OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
			SOFTWARE.
*/


ob_start(); //prevent the "header already sent" error
session_start(); //launch session

//===============================================================
//                      Configuration
//===============================================================

define('APP_CONFIG', require 'inc/config/config.php'); // <---- Edit this file for app configuration
define('APP_URL', APP_CONFIG[ 'APP_URL' ]);
define('APP_PROCESS', APP_CONFIG[ 'APP_URL' ] . '/process');
define('APP_RESOURCES', APP_CONFIG[ 'APP_RESOURCES' ]);

//===============================================================
//                        Load resources
//===============================================================
if (APP_CONFIG[ 'ALLOW_AUTOLOADER' ])

	spl_autoload_register(function ($class) {
		include 'inc/classes/' . $class . '.php';
	});

else if (APP_CONFIG[ 'ALLOW_MCV_AUTOLOADER' ]) {
	spl_autoload_register(function ($class) {
		if (is_file('inc/classes/' . $class . '.php'))
			include 'inc/classes/' . $class . '.php';
	});
	spl_autoload_register(function ($class) {
		if (is_file('inc/controllers/' . $class . '.php'))
			include 'inc/controllers/' . $class . '.php';
	});
	spl_autoload_register(function ($class) {
		if (is_file('inc/middlewares/' . $class . '.php'))
			include 'inc/middlewares/' . $class . '.php';
	});
}

if (APP_CONFIG[ 'DEBUG_MODE' ]) {
	error_reporting(30719);
	var_dump($_GET);
	echo "<br>";
	var_dump($_POST);
	echo "<br>";
	var_dump($_SESSION);
}


if (APP_CONFIG[ 'LOAD_COMPOSER' ]) require 'vendor/autoload.php';

//===============================================================
//            Check requested view in VIEWS_DIRECTORY
//===============================================================
$views = scandir(APP_CONFIG[ 'VIEWS_DIRECTORY' ], SCANDIR_SORT_ASCENDING);

if (!isset($_GET[ 'view' ]) || empty($_GET[ 'view' ])) {
	/*
	 *	Requested view isn't found in the views directory
	 *  => redirect to error view with 404 code
	 */
	header('Location: ' . APP_CONFIG[ 'APP_URL' ] . '/app/' . APP_CONFIG[ 'DEFAULT_PAGE' ]);
	exit;

}

// define default view
if (in_array($_GET[ 'view' ] . '.php', $views, TRUE)) {
	$view = $_GET[ 'view' ];
} else {
	header('Location: ' . APP_CONFIG[ 'APP_URL' ] . '/error/404');
	exit;
}

//===============================================================
//                      Generate view
//===============================================================
if (!in_array($view, ['error', 'signin', 'signup', 'logout'])) include APP_CONFIG[ 'LAYOUTS_DIRECTORY' ] . "/header.php"; // link header
include APP_CONFIG[ 'VIEWS_DIRECTORY' ] . "/" . $view . '.php'; // link view
if (!in_array($view, ['error', 'signin', 'signup', 'logout'])) include APP_CONFIG[ 'LAYOUTS_DIRECTORY' ] . "/footer.php"; // link footer
