<?php
use App\Models\Database;
$eloquent = Database::getInstance();

if(isset($_POST["change_balance"]) && $_POST["change_balance"] == "YES" ){
    $isUpdated = updateLog("balance", $_POST["balanceToUpdate"], $_POST["log_id"]);
    if($isUpdated > 0){
        echo "Success";
    }
}

if(isset($_POST["change_operator"]) && $_POST["change_operator"] == "YES" ){
    $isUpdated = updateLog("contact_operator", $_POST["operator"], $_POST["log_id"]);
    if($isUpdated > 0){
        echo "Success";
    }
}
if(isset($_POST["change_type"]) && $_POST["change_type"] == "YES" ){
    $isUpdated = updateLog("contact_type", $_POST["contact_type"], $_POST["log_id"]);
    if($isUpdated > 0){
        echo "Success";
    }
}

if(isset($_POST["change_number"]) && $_POST["change_number"] == "YES" ){
    $isUpdated = updateLog("contact_number", $_POST["number"], $_POST["log_id"]);
    if($isUpdated > 0){
        echo "Success";
    }
}

function updateLog($column, $value, $id)
{
    $eloquent = Database::getInstance();
    $tableName = "temp_campaign_process_logs";
    $columnValue[$column] = $value;
    $whereValue["id"] = $id;
    return $eloquent->updateData($tableName, $columnValue, @$whereValue);
}

if(isset($_POST["delete_log"]) && $_POST["delete_log"] == "YES")
{

    $columnName = $tableName = $whereValue = null;
    $tableName = "temp_campaign_process_logs";
    $whereValue["id"] = $_POST['del_log_id'];
    $isDeleted = $eloquent->deleteData($tableName, $whereValue);

    if($isDeleted > 0){
        echo "Success";
    }
}