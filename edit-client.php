<?php
include "config/boostrap.php";
use App\Http\Controllers\View;

$view = new View;

$view->loadContent("include", "session");
$view->loadContent("include", "_header");
$view->loadContent("content", "edit-client");
$view->loadContent("include", "_footer");
