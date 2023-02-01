<?php
use App\Models\Database;

$eloquent = Database::getInstance();

if(isset($_POST['updateContact'])){
    $tableName = "contact_lists";
    $columnValue["contact_group_id"]    = $_POST['contactGroupId'];
    $columnValue["contact_number"]      = $_POST['contactNumber'];
    $columnValue["contact_operator"]    = $_POST['contactOperator'];
    $columnValue["contact_type"]        = $_POST['contactType'];
    $whereValue["id"]                   = $_POST['contactId'];
    $isUpdated = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}

## ===*=== [F]ETCH CONTACT DATA ===*=== ##
if(isset($_GET['eid'])){
    $columnName = $tableName = $joinType = $onCondition = $whereValue = null;
    $columnName["1"] = "contact_lists.id as contact_id";
    $columnName["2"] = "contact_lists.contact_group_id";
    $columnName["3"] = "contact_lists.contact_number";
    $columnName["4"] = "contact_lists.contact_operator";
    $columnName["5"] = "contact_lists.contact_type";
    $columnName["6"] = "contact_groups.contact_group_name";
    $tableName["MAIN"] = "contact_lists";
    $joinType = "INNER";
    $tableName["1"] = "contact_groups";
    $onCondition["1"] = ["contact_groups.id", "contact_lists.contact_group_id"];
    $whereValue["contact_lists.id"] = $_GET['eid'];
    $contact = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition , $whereValue/*, @$formatBy*/);
    $contact = $contact[0];
}
## ===*=== [F]ETCH CONTACT GROUP DATA ===*=== ##
$columnName = $tableName = $whereValue = null;
$tableName = "contact_groups";
$columnName["1"] = "id";
$columnName["2"] = "contact_group_name";
$contactGroups = $eloquent->selectData($columnName, $tableName);
?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-md-12 layout-spacing">
        <?php
        #== REGISTRATION CONFIRMATION MESSAGE
        if(isset($_POST['updateContact']))
        {
            if($isUpdated > 0)
            {
                echo notification("success", "Contact save successfully.");
            } else {
                echo notification("danger", "Something went wrong Cannot update contact please recheck.");
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
                <form class="row g-3" action="" method="POST">
                    <input type="hidden" name="contactId" value="<?php echo $contact["contact_id"] ?>"/>
                    <div class="col-md-12">
                        <label for="contactGroupId" class="form-label">Contact Groups</label>
                        <select name="contactGroupId" id="contactGroupId" class="form-select">
                            <option value="">Select a Group</option>
                            <?php
                            if(!empty($contactGroups)){
                                foreach ($contactGroups as $eachContactGroup){
                                $selected = ($contact["contact_group_id"] == $eachContactGroup["id"]) ? "selected" : "";
                                 echo <<<EOD
                                        <option $selected value="{$eachContactGroup["id"]}">{$eachContactGroup["contact_group_name"]}</option>  
                                  EOD;
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input name="contactNumber"  value="<?php echo $contact["contact_number"] ?>" type="text" class="form-control" id="contactNumber" placeholder="Enter contact number" required />
                    </div>
                    <div class="col-md-12">
                        <label for="contactOperator" class="form-label">Contact Operator</label>
                        <select name="contactOperator" id="contactOperator" class="form-select">
                            <option value="" selected>Select a Operator</option>
                            <option <?php echo ($contact["contact_operator"] == "GP") ? "selected" : ""; ?> value="GP">Grameenphone</option>
                            <option <?php echo ($contact["contact_operator"] == "BL") ? "selected" : ""; ?> value="BL">Banglalink</option>
                            <option <?php echo ($contact["contact_operator"] == "RB") ? "selected" : ""; ?> value="RB">Robi</option>
                            <option <?php echo ($contact["contact_operator"] == "TT") ? "selected" : ""; ?> value="TT">Teletalk</option>
                            <option <?php echo ($contact["contact_operator"] == "GP ST") ? "selected" : ""; ?> value="GP ST"> Skitto</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="contactType" class="form-label">Contact Type</label>
                        <select name="contactType" id="contactType" class="form-select">
                            <option value="" selected>Select a Type</option>
                            <option <?php echo ($contact["contact_type"] == "Prepaid") ? "selected" : ""; ?> value="Prepaid">Prepaid</option>
                            <option <?php echo ($contact["contact_type"] == "Postpaid") ? "selected" : ""; ?> value="Postpaid">Postpaid</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <button name="updateContact" type="submit" class="btn btn-success float-end">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>