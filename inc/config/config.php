<?php

/*
 * This file contains application configuration such as database auth credentials, app url, and much more ...
 */

return [

	//===============================================================
	//                        APP CONFIG
	//===============================================================

	"APP_URL" => "",

	//===============================================================
	//                        DATABASE
	//===============================================================

	"db" => [
		"host"     => "",
		"database" => "",
		"user"     => "",
		"password" => "",
	],

	//===============================================================
	//                        CONTACT
	//===============================================================

	"CONTACT_EMAIL" => "",

	//===============================================================
	//                  SERVER CONFIGURATION
	//===============================================================

	"APP_MAX_UPLOAD_FILE_SIZE" => 300, //kilo bytes
	"PROCESS_DIRECTORY"        => ".",
	"LAYOUTS_DIRECTORY"        => "../../inc/layouts",
	"DEBUG_MODE"               => FALSE,
	"ALLOW_AUTOLOADER"         => FALSE,
	"ALLOW_MCV_AUTOLOADER"     => FALSE,
	"LOAD_COMPOSER"            => TRUE,
	"APP_RESOURCES"            => APP_URL . "/resources",

	//===============================================================
	//                        EXT SERVICES KEYS
	//===============================================================

	"CAPTCHA_SECRET"     => "",
	"MAPBOX_API_SECRET"  => "",
	"MAILJET_API"        => "",
	"MAILJET_API_SECRET" => "",
	"CAPTCHA_SITEKEY"    => "",
];