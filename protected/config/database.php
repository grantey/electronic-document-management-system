<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=sedo1',
	'emulatePrepare' => true,
	'username' => 'mysql',
	'password' => 'mysql',
	'charset' => 'utf8',
);