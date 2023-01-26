<?php
use App\Http\Controllers\Controller;
$ctrl = new Controller();
## ===*=== [LOGOUT] SESSION ===*=== ##
if($_REQUEST['exit'] == "yes")
{
    session_start();
    session_destroy();
    $ctrl->redirectPage("index.php");
}

## ===*=== [RESTRICTION] ACCESS | ADMIN ===*=== ##
if(empty($_SESSION['USER_LOGIN_ID']) && empty($_SESSION['USER_LOGIN_TIME']))
{
    $ctrl->redirectPage("index.php");
}

## ===*=== [ADMIN] ACCESS LABEL CONTROL | ADMIN ===*=== ##
$pagename = basename($_SERVER['PHP_SELF']);

#== USER
$userCanNotAccess = ["list-admin.php", "edit-admin.php", "add-client.php", "edit-client.php", "index.php"];

if(in_array($pagename, $userCanNotAccess) && $_SESSION['USER_LOGIN_ROLE'] == "User")
{
//    $ctrl->redirectPage("dashboard.php");
}

if(in_array($pagename, (array)"index.php") && $_SESSION['USER_LOGIN_ROLE'] == "Admin")
{
//    $ctrl->redirectPage("dashboard.php");
}
