<?php
## ===*=== [LOGOUT] SESSION ===*=== ##
if(@$_REQUEST['exit'] == "yes")
{
    session_start();
    session_destroy();
    header("Location: index.php", 302);
}

## ===*=== [RESTRICTION] ACCESS | ADMIN ===*=== ##
if(empty($_SESSION['USER_LOGIN_ID']) && empty($_SESSION['USER_LOGIN_TIME']))
{
//    header("Location: index.php", 302);
}

## ===*=== [L]OGOUT SESSION | ADMIN USER ===*=== ##
if(@$_REQUEST['exit'] == "lock")
{
    #== IN GET METHOD IF SOMEONE SENDS "lock" AS VALUE AGAINST "exit"
    header("Location: lock-screen.php");
}

## ===*=== [ADMIN] ACCESS LABEL CONTROL | ADMIN ===*=== ##
$pagename = basename($_SERVER['PHP_SELF']);

#== USER
$userCanAccess = ["add-admin.php", "add-client.php", "edit-admin.php", "edit-client.php", "list-admin.php", ""];

if(in_array($pagename, $userCanAccess) && $_SESSION['USER_LOGIN_ROLE'] == "User")
{
    header("Location: dashboard.php");
}

//
//#== SALES MANAGER
//$salesManagerPages = ['create-product.php', 'list-product.php', 'create-slider.php', 'list-slider.php', 'create-admin.php', 'list-admin.php', 'create-category.php', 'list-category.php', 'create-subcategory.php', 'list-subcategory.php'];
//
//if(in_array($pagename, $salesManagerPages) && $_SESSION['SMC_login_admin_type'] == "Sales Manager")
//{
//    header("Location: dashboard.php");
//}
## ===*=== [A]DMIN ACCESS LABEL CONTROL | ADMIN ===*=== ##
