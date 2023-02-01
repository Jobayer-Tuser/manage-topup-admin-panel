<?php

namespace App\Http\Controllers;
use App\Models\Database;
use PDO;

class LoginController extends Controller
{
    private object $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    ## [L]ogin Function | ADMIN LOGIN
    public function tryLogin(string $username, string $password) : array | bool
    {
        $columnName = "*";
        $tableName = "admins";
        $whereValue["admin_status"] = "Active";
        $whereValue["admin_email"] = $username;
        $admin = $this->db->selectData($columnName, $tableName, $whereValue);

        if (!empty($admin)){
            if (verify_pass($password, $admin[0]["admin_pass"])){
                $admin[0]["role"] = "Admin";
                return $admin;
            }
        } else {

            $columnName = $tableName = $whereValue = null;
            $columnName = "*";
            $tableName = "client_profile";
            $whereValue["username"] = $username;
            $whereValue["status"] = "Active";
            $user = $this->db->selectData($columnName, $tableName, $whereValue);

            if ($user > 0){
                if (verify_pass($password, $user[0]["password"])){
                    $user[0]["role"] = "User";
                    return $user;
                }
            }
        }
        return 0;
    }

}