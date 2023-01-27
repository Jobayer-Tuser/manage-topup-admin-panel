<?php session_start();

use App\Http\Controllers\Controller;
$ctrl = new Controller();

## ===*=== [LOGOUT] SESSION ===*=== ##
if(@$_REQUEST['exit'] == "yes")
{
    session_destroy();
    $ctrl->redirectPage("index.php");
}

## ===*=== [LOGOUT] SESSION ON INACTIVE FOR 15 MINUTE ===*=== ##
if(isset($_SESSION["user_login_time"])){
    if (time()- $_SESSION["user_login_time"] > 900){
        session_destroy();
        $ctrl->redirectPage("index.php");
    }
}

## ===*=== [RESTRICTION] ACCESS | ADMIN ===*=== ##
if(!isset($_SESSION['user_login_id']) || !isset($_SESSION['user_login_time'])) {
    $ctrl->redirectPage("index.php");
}


## ===*=== [ADMIN] ACCESS LABEL CONTROL | ADMIN ===*=== ##
$pagename = basename($_SERVER['PHP_SELF']);

#== USER
$userCanNotAccess = ["add-admin.php", "edit-admin.php", "add-client.php", "edit-client.php", "index.php"];

if(in_array($pagename, $userCanNotAccess) && $_SESSION['user_login_role'] == "User")
{
    $ctrl->redirectPage("dashboard.php");
}

if($pagename == "index.php" && $_SESSION['user_login_role'] == "Admin")
{
    $ctrl->redirectPage("dashboard.php");
}
