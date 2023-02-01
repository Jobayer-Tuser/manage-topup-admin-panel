<?php
use App\Models\Database;
$eloquent = Database::getInstance();

## ===*=== [U]UPDATE ADMIN DATA ===*=== ##
if(isset($_POST['updateAdmin'])){
    $tableName = "admins";
    $columnValue["admin_name"]   = $_POST['adminName'];
    $columnValue["admin_email"]  = $_POST['adminEmail'];
    $columnValue["admin_status"] = $_POST['adminStatus'];
    $whereValue["id"] = $_POST['adminId'];
    $isUpdated = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}

## ===*=== [F]ETCH ADMIN DATA ===*=== ##
if(isset($_GET['eid'])){
    $columnName = "*";
    $tableName = "admins";
    $whereValue["id"] = $_GET["eid"];
    $admin = $eloquent->selectData($columnName, $tableName, @$whereValue);
    $admin = $admin[0];
}

?>
<div class="row layout-top-spacing">
    <?php
    #== UPDATE CONFIRMATION MESSAGE
    if(isset($_POST['updateAdmin']))
    {
        if($isUpdated > 0)
        {
            echo notification("success", "New admin info update successfully");
        } else {
            echo notification("danger", "Something went wrong Cannot update admin please recheck");
        }
    }
    ?>
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Add Admin</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <?php
                $activeSelected = ($admin['admin_status']) == "Active" ? "selected" : "";
                $inactiveSelected = ($admin['admin_status']) == "Inactive" ? "selected" : "";

                $adminEditForm = <<<EOD
                    <form class="row g-3" action="" method="POST">  
                    <input type="hidden" name="adminId" value="{$admin['id']}"/>
                        <div class="col-md-6">
                            <label for="adminName" class="form-label">Full Name</label>
                            <input name="adminName" value="{$admin['admin_name']}" type="text" class="form-control" id="adminName" placeholder="Enter your full name" required />
                        </div>
                        <div class="col-md-6">
                            <label for="adminEmail" class="form-label">Email</label>
                            <input name="adminEmail" value="{$admin['admin_email']}" type="email" class="form-control" id="adminEmail" placeholder="Enter your email" required />
                        </div>
                       
                        <div class="col-md-6">
                            <label for="adminStatus" class="form-label">Status</label>
                            <select name="adminStatus" id="adminStatus" class="form-select">
                                <option value="">Select a status</option>
                                <option {$activeSelected} value="Active">Active</option>
                                <option {$inactiveSelected} value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button name="updateAdmin" type="submit" class="btn btn-success float-end">Save</button>
                        </div>
                    </form>
                EOD;
                echo $adminEditForm;
                ?>
            </div>
        </div>
    </div>
</div>