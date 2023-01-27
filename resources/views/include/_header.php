<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo pageTitle(); ?> </title>
    <link rel="icon" type="image/x-icon" href="public/assets/src/assets/img/favicon.ico"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="public/assets/src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/assets/css/light/main.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/plugins/css/light/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/plugins/src/waves/waves.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/layouts/css/light/structure.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/plugins/src/highlight/styles/monokai-sublime.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="public/assets/src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="public/assets/src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <link rel="stylesheet" type="text/css" href="public/assets/src/plugins/src/table/datatable/datatables.css" />
    <link rel="stylesheet" type="text/css" href="public/assets/src/plugins/css/light/table/datatable/dt-global_style.css"/>
    <link rel="stylesheet" type="text/css" href="public/assets/src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css"/>

    <link rel="stylesheet" type="text/css" href="public/assets/src/assets/css/light/elements/alert.css"/>
    <link href="public/assets/src/plugins/src/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
    <link href="public/assets/src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/layouts/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/assets/css/light/authentication/auth-cover.css" rel="stylesheet" type="text/css" />

    <link href="public/assets/src/plugins/src/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/src/plugins/css/light/notification/snackbar/custom-snackbar.css" rel="stylesheet" type="text/css" />

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body class="layout-boxed">
<!--  BEGIN NAVBAR  -->
<div class="header-container container-xxl">
    <header class="header navbar navbar-expand-sm expand-header">
        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="dashboard.php">
<!--                    <img src="public/assets/images/superb_logo.png" class="navbar-logo" alt="logo">-->
                </a>
            </li>
            <li class="nav-item theme-text">
<!--                <a href="dashboard.php" class="nav-link"> SuperbNexus </a>-->
                <a href="dashboard.php" class="nav-link"> LOGO </a>
            </li>
        </ul>

        <div class="search-animated toggle-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <form class="form-inline search-full form-inline search" role="search">
                <div class="search-bar">
                    <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x search-close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </div>
            </form>
            <span class="badge badge-secondary">Ctrl + /</span>
        </div>

        <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">
            <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar-container">
                        <div class="avatar avatar-sm avatar-indicators avatar-online">
                            <img alt="avatar" src="public/assets/src/assets/img/profile-30.png" class="rounded-circle">
                        </div>
                    </div>
                </a>

                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <div class="emoji me-2">
                                &#x1F44B;
                            </div>
                            <div class="media-body">
                                <h5><?php echo $_SESSION['USER_LOGIN_NAME'] ?? "No name"; ?></h5>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Profile</span>
                        </a>
                    </div>
                    <div class="dropdown-item">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg> <span>Reset Password</span>
                        </a>
                    </div>
                    <div class="dropdown-item">
                        <a href="?exit=yes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <!--  BEGIN SIDEBAR  -->
    <?php include "resources/views/include/_navbar.php"; ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="container">
            <div class="container">

    <!--  BEGIN BREADCRUMBS  -->
    <?php include"resources/views/include/_breadcrumb.php"?>