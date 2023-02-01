<?php
use App\Models\Database;
$eloquent = Database::getInstance();

## ===*=== [U]UPDATE ADMIN DATA ===*=== ##
if(isset($_POST['updateCompany'])){
    $tableName = "client_company";
    $columnValue["company_name"]   = $_POST['companyName'];
    $columnValue["company_address"]   = $_POST['companyAddress'];
    $columnValue["company_website"]   = $_POST['companyWebsite'];
    $whereValue["id"] = $_POST['companyId'];
    $isUpdated = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}

## ===*=== [F]ETCH COMPANY DATA ===*=== ##
if(isset($_GET['eid'])){
    $columnName = "*";
    $tableName = "client_company";
    $whereValue["id"] = $_GET["eid"];
    $company = $eloquent->selectData($columnName, $tableName, @$whereValue);
    $company = $company[0];
}

?>

<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['updateCompany']))
    {
        if($isUpdated > 0)
        {
            echo notification("success", "New company update successfully");
        } else {
            echo notification("danger", "Something went wrong Cannot update company please recheck");
        }
    }
    ?>
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><?php echo pageTitle(); ?></h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <?php
                echo <<<EOD
                <form class="row g-3" action="" method="POST">
                <input type="hidden" name="companyId" value="{$company['id']}"/>
                    <div class="col-md-4">
                        <label for="companyName" class="form-label">Company Name</label>
                        <input name="companyName" value="{$company['company_name']}" type="text" class="form-control" id="companyName" placeholder="Enter company name" required />
                    </div>
                    <div class="col-md-4">
                        <label for="companyAddress" class="form-label">Company Address</label>
                        <input name="companyAddress" value="{$company['company_address']}"type="text" class="form-control" id="companyAddress" placeholder="Enter company address" required />
                    </div>
                    <div class="col-md-4">
                        <label for="companyWebsite" class="form-label">Company Website</label>
                        <input name="companyWebsite" value="{$company['company_website']}" type="text" class="form-control" id="companyWebsite" placeholder="Enter company website" required />
                    </div>

                    <div class="col-md-12">
                        <button name="updateCompany" type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </form>
EOD;
                ?>
            </div>
        </div>
    </div>
</div>