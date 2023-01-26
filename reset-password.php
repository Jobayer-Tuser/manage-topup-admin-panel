<?php

include "config/boostrap.php";

use App\Http\Controllers\View;

$view = new View;

$view->loadContent("include", "session");
$view->loadContent("include", "_header");
$view->loadContent("content", "reset-password");
$view->loadContent("include", "_footer");

