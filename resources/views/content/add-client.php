<?php
use App\Models\Database;
$eloquent = Database::getInstance();

if(isset($_POST['saveNewClient'])){
    if(!empty($_POST['companyId']) && !empty($_POST['clientName']) && !empty($_POST['clientUsername'])&& !empty($_POST['clientStatus'])&& !empty($_POST['clientPass']) )
    {
        $tableName = "client_profile";
        $columnValue["client_company_id"] = $_POST['companyId'];
        $columnValue["full_name"] = $_POST['clientName'];
        $columnValue["username"] = $_POST['clientUsername'];
        $columnValue["password"] = bcrypt($_POST['clientPass']);
        $columnValue["status"] = $_POST['clientStatus'];
        $registerClient = $eloquent->insertData($tableName, $columnValue);
    }
}

# DELETE COMPANY DATA #
if (isset($_POST['del_Client'])){
    $columnName = $tableName = $whereValue = null;
    $tableName = "client_profile";
    $whereValue["id"] = $_POST['delClientID'];
    $isDeleted = $eloquent->deleteData($tableName, $whereValue);
}

# FETCH COMPANY DATA #
$columnName = $tableName = null;
$columnName["1"] = "id";
$columnName["2"] = "company_name";
$tableName = "client_company";
$companies = $eloquent->selectData($columnName, $tableName);

# FETCH CLIENT DATA #
$columnName = $tableName = $joinType = $onCondition = null;
$columnName["1"] = "client_profile.client_company_id";
$columnName["2"] = "client_profile.full_name";
$columnName["3"] = "client_profile.username";
$columnName["4"] = "client_profile.status";
$columnName["6"] = "client_profile.id";
$columnName["5"] = "client_company.company_name";
$tableName["MAIN"] = "client_profile";
$joinType = "INNER";
$tableName["1"] = "client_company";
$onCondition["1"] = ["client_company.id", "client_profile.client_company_id"];
$clients = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, /*@$whereValue, @$formatBy*/);

?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
        <?php
        #== REGISTRATION CONFIRMATION MESSAGE
        if(isset($_POST['saveNewClient']) || isset($_POST['del_Client']))
        {
            if(@$registerClient > 0) {
                echo notification("success", "Client save successfully.");
            } else if (@$isDeleted > 0){
                echo notification("success", "Client deleted successfully.");
            } else {
                echo notification("danger", "Something went wrong please recheck!");
            }
        }
        ?>
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><?php echo pageTitle();?></h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="row g-3" action="" method="POST">
                    <div class="col-md-4">
                        <label for="companyId" class="form-label">Company Name</label>
                        <select name="companyId" id="companyId" class="form-select">
                            <option value="">Select a Company</option>
                            <?php
                                foreach ($companies as $eachCompany){
                                    echo <<<EOD
                                        <option value="{$eachCompany['id']}"> {$eachCompany["company_name"]}</option>
                                    EOD;
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="clientName" class="form-label">Full Name</label>
                        <input name="clientName" type="text" class="form-control" id="clientName" placeholder="Enter your full name" required />
                    </div>
                    <div class="col-md-4">
                        <label for="clientUsername" class="form-label">Email</label>
                        <input name="clientUsername" type="text" class="form-control" id="clientUsername" placeholder="Enter client email" required />
                    </div>
                    <div class="col-md-4">
                        <label for="clientPass" class="form-label">Password</label>
                        <input name="clientPass" type="password" class="form-control " id="clientPass" required />
                    </div>
                    <div class="col-md-4">
                        <label for="clientStatus" class="form-label">Status</label>
                        <select name="clientStatus" id="clientStatus" class="form-select">
                            <option value="" selected>Select a status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <button name="saveNewClient" type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                <tr>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($clients) && is_array($clients)){
                    foreach ($clients as $eachClient){
                        $status = ($eachClient['status'] == "Active") ? "success" : "dark";
                        echo <<<EOD
                        <tr>
                            <td>{$eachClient['company_name']}</td>
                            <td>{$eachClient['full_name']}</td>
                            <td>{$eachClient['username']}</td>
                            <td><span class="badge badge-{$status} mb-2 me-4">{$eachClient['status']}</span></td>
                            <td>
                                <a href="edit-client.php?eid={$eachClient['id']}" class="btn btn-warning btn-sm mb-2 _effect--ripple waves-effect waves-light">Edit</a>
                                <form action="" method="post">
                                    <input type="hidden" name="delClientID" value="{$eachClient['id']}"/>
                                    <button name="del_Client" type="submit" id="del_company" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light">Delete</button>
                                </form>
                            </td>
                        </tr>
                        EOD;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>