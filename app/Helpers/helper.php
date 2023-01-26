<?php
use App\Models\Eloquent;

    function notification(string $status, string $message): string
    {
        $notification = <<<EOD
            <div class="alert alert-light-{$status} alert-dismissible fade show border-0 mb-4" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                {$message} 
            </div>
           EOD;
        return $notification;
    }

    function getPageName(): string
    {
        $pageName = basename($_SERVER['PHP_SELF']);
        return str_replace('.php', '', $pageName);
    }

    function activeMenu()  : string
    {
        $active = (getPageName() == index) ? "active" : "";
        return $active;
    }

/**
 * @throws Exception
 */
function randomString($string_length) : string {
    return substr(bin2hex(random_bytes($string_length)), 0, $string_length);
}

function randomStringSuffle($string_length): string {
    $string = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghigklmnopqrstuvwxyz";
    return substr(str_shuffle($string), 0, $string_length);
}

function pageTitle() : string {
    $pageName = basename($_SERVER['PHP_SELF']);
    $pageName = str_replace('.php', '', $pageName);

    if($pageName == null)
    {
        $pageTitle = ucwords('Dashboard');
    }
    else
    {
        $strReplace =  str_replace('-', ' ', $pageName);
        $pageTitle = ucwords($strReplace);
    }
    return $pageTitle;
}

function deleteData($table_name, $where_value) : bool {
    $eloquent = Eloquent::getInstance();
    $tableName = $table_name;
    $whereValue["id"] = $where_value;
    return $eloquent->deleteData($tableName, $whereValue);
}

function bcrypt($password) : string {
    $option = ["cost" => 12];
    return password_hash($password, PASSWORD_BCRYPT, $option);
}

function verify_pass($inputPass, $dbPass ) : bool {
    return password_verify($inputPass, $dbPass);
}