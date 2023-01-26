<?php
include "config/boostrap.php";
use App\Http\Controllers\View;

$view = new View;

$view->loadContent("content", "ajax-request");
