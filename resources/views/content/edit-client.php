<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

if(isset($_POST["updateClient"])){
    $tableName = "client_profile";
    $columnValue["client_company_id"] = $_POST['companyId'];
    $columnValue["full_name"] = $_POST['clientName'];
    $columnValue["username"] = $_POST['clientUsername'];
    $columnValue["status"] = $_POST['clientStatus'];
    $whereValue["id"] = $_POST['clientId'];
    $isUpdated = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}

if(isset($_GET['eid'])) {
    # FETCH CLIENT DATA #
    $columnName = $columnValue = $tableName = $whereValue =  null;
    $columnName["1"] = "client_profile.client_company_id";
    $columnName["2"] = "client_profile.full_name";
    $columnName["3"] = "client_profile.username";
    $columnName["4"] = "client_profile.status";
    $columnName["5"] = "client_profile.id as client_id";
    $columnName["6"] = "client_company.company_name";
    $columnName["6"] = "client_company.id as company_id";
    $tableName["MAIN"] = "client_profile";
    $joinType = "INNER";
    $tableName["1"] = "client_company";
    $onCondition["1"] = ["client_company.id", "client_profile.client_company_id"];
    $whereValue["client_profile.id"] = $_GET["eid"];
    $client = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue /*,@$formatBy*/);
    $client = $client[0];
}
# FETCH COMPANY DATA #
$columnName = $tableName = null;
$columnName["1"] = "id";
$columnName["2"] = "company_name";
$tableName = "client_company";
$companies = $eloquent->selectData($columnName, $tableName);
?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
        <?php
        #== REGISTRATION CONFIRMATION MESSAGE
        if(isset($_POST['updateClient']))
        {
            if($isUpdated > 0) {
                echo notification("success", "New client update successfully");
            } else {
                echo notification("danger", "Something went wrong Cannot update client please recheck");
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
                    <input type="hidden" name="clientId" value="<?php echo $client["client_id"] ;?>"/>
                    <div class="col-md-4">
                        <label for="companyId" class="form-label">Company Name</label>
                        <select name="companyId" id="companyId" class="form-select">
                            <option value="">Select a Company</option>
                            <?php
                                foreach ($companies as $eachCompany){
                                    $active = ($client["client_company_id"] == $eachCompany['id']) ? "selected" : "";
                                    echo <<<EOD
                                        <option $active value="{$eachCompany['id']}"> {$eachCompany["company_name"]} </option>
                                    EOD;
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="clientName" class="form-label">Full Name</label>
                        <input name="clientName" value="<?php echo $client["full_name"] ?>" type="text" class="form-control" id="clientName" placeholder="Enter your full name" required />
                    </div>
                    <div class="col-md-4">
                        <label for="clientUsername" class="form-label">Email</label>
                        <input name="clientUsername" value="<?php echo $client["username"] ?>" type="text" class="form-control" id="clientUsername" placeholder="Enter client email" required />
                    </div>
                    <div class="col-md-4">
                        <label for="clientStatus" class="form-label">Status</label>
                        <select name="clientStatus" id="clientStatus" class="form-select">
                            <option value="">Select a status</option>
                            <option <?php echo ($client["status"] == "Active") ? "selected" : "" ?> value="Active">Active</option>
                            <option <?php echo ($client["status"] == "Inactive") ? "selected" : "" ?> value="Inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <button name="updateClient" type="submit" class="btn btn-success float-end">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>