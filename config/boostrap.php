<?php
//header("Cache-Control: no-cache, must-revalidate");
error_reporting(E_ALL); //to show errors
ini_set('display_errors', TRUE); //Sets the value of a configuration option
ini_set('display_startup_errors', TRUE);

define('BASE_PATH', realpath(dirname(__FILE__,2)));

require(BASE_PATH . "/vendor/autoload.php");

# CONFIGURATION FILES
include("site.php");
include("server.php");
include("database.php");
