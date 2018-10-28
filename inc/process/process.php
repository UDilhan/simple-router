<?php

ob_start(); //prevent the "header already sent" error
session_start(); //launch session

//===============================================================
//                      Configuration
//===============================================================

define("APP_CONFIG", require("../config/config.php")); // <---- Edit this file for app configuration

//===============================================================
//                        Load resources
//===============================================================

if (APP_CONFIG[ 'ALLOW_AUTOLOADER' ])

	spl_autoload_register(function ($class) {
		include 'inc/class/' . $class . '.php';
	});

else if (APP_CONFIG[ 'ALLOW_MCV_AUTOLOADER' ]) {
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

if (APP_CONFIG[ 'DEBUG_MODE' ]) {
	error_reporting(30719);
	var_dump($_GET);
	echo "<br>";
	var_dump($_POST);
}

if (APP_CONFIG[ 'LOAD_COMPOSER' ]) require '../../vendor/autoload.php';

$processes = scandir(APP_CONFIG[ 'PROCESS_DIRECTORY' ]);

if (isset($_GET[ 'pid' ]) && !empty($_GET[ 'pid' ]))

	if (in_array($_GET[ 'pid' ] . '.php', $processes)) $app = $_GET[ 'pid' ];
	else {
		header('Location: ' . APP_CONFIG[ 'APP_URL' ] . '/error/404');
		exit;
	}

else $app = APP_CONFIG[ 'DEFAULT_PAGE' ]; // define default app

require($_GET[ 'pid' ] . ".php");