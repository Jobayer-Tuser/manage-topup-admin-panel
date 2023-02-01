<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

if(isset($_POST['updateCampaign'])){
    $tableName = "campaign_lists";
    $columnValue["campaign_lot_id"] = $_POST["campaignLotId"];
    $columnValue["campaign_title"] = $_POST['campaignT'];
    $columnValue["service_type"] = $_POST['serviceType'];
    $columnValue["total_contact_number"] = $_POST['totalCNum'];
    $columnValue["total_recharge_amount"] = $_POST['totalRechAmount'];
    $columnValue["campaign_status"] = $_POST['campaignStat'];
    $columnValue["schedule_time"] = $_POST['scheduleTime'];
    $columnValue["updated_at"] = date("Y-m-d H:i:s");
    $whereValue["id"] = $_POST['campaignId'];
    $isUpdated = $eloquent->updateData($tableName, $columnValue, $whereValue);
}

## ===*=== [F]ETCH ADMIN DATA ===*=== ##
if(isset($_GET['eid'])){
    $columnValue = $columnName = $whereValue = null;
    $columnName = "*";
    $tableName = "campaign_lists";
    $whereValue["id"] = $_GET["eid"];
    $campaign = $eloquent->selectData($columnName, $tableName, $whereValue);
    $campaign = $campaign[0];
}

?>
<div class="row layout-top-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['updateCampaign']))
    {
        if($isUpdated > 0)
        {
            echo notification("success", "Campaign update successfully");
        } else {
            echo notification("danger", "Something went wrong Cannot update campaign please recheck");
        }
    }
    ?>
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Add Campaign</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="row g-3" action="" method="POST">
                    <input type="hidden" name="campaignId" value="<?php echo $campaign["id"] ?>"/>
                    <div class="col-md-4">
                        <label for="campaignLotId" class="form-label">Campaign lot ID</label>
                        <input name="campaignLotId" value="<?php echo $campaign["campaign_lot_id"]; ?>" type="text" class="form-control" id="campaignLotId" placeholder="Enter campaign title" required />
                    </div>
                    <div class="col-md-4">
                        <label for="campaignT" class="form-label">Campaign Title</label>
                        <input name="campaignT" value="<?php echo $campaign["campaign_title"]; ?>" type="text" class="form-control" id="campaignT" placeholder="Enter campaign title" required />
                    </div>
                    <div class="col-md-4">
                        <label for="serviceType" class="form-label">Service Type</label>
                        <select name="serviceType" id="serviceType" class="form-select">
                            <option value="" selected>Select a service</option>
                            <option <?php echo ($campaign["service_type"] == "Balance") ? "selected" : ""; ?> value="Balance">Balance</option>
                            <option <?php echo ($campaign["service_type"] == "Combo Offer") ? "selected" : ""; ?> value="Combo Offer">Combo Offer</option>
                            <option <?php echo ($campaign["service_type"] == "Talk Time") ? "selected" : ""; ?> value="Talk Time">Talk Time</option>
                            <option <?php echo ($campaign["service_type"] == "Internet") ? "selected" : ""; ?> value="Internet">Internet</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="totalCNum" class="form-label">Total contact number</label>
                        <input name="totalCNum" value="<?php echo $campaign["total_contact_number"]; ?>"  type="number" class="form-control" id="totalCNum" placeholder="Total contact number" required />
                    </div>
                    <div class="col-md-4">
                        <label for="totalRechAmount" class="form-label">Total recharge amount</label>
                        <input name="totalRechAmount" value="<?php echo $campaign["total_recharge_amount"]; ?>"  type="text" class="form-control" id="totalRechAmount" placeholder="Total recharge amount" required />
                    </div>
                    <div class="col-md-4">
                        <label for="campaignStat" class="form-label">Campaign status</label>
                        <select name="campaignStat" id="campaignStat" class="form-select">
                            <option value="" selected>Select a service</option>
                            <option <?php echo $campaign["campaign_status"] == "Pending" ? "selected" : ""; ?> value="Pending">Pending</option>
                            <option <?php echo $campaign["campaign_status"] == "Processing" ? "selected" : ""; ?> value="Processing">Processing</option>
                            <option <?php echo $campaign["campaign_status"] == "Completed" ? "selected" : ""; ?> value="Completed">Completed</option>
                            <option <?php echo $campaign["campaign_status"] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
                            <option <?php echo $campaign["campaign_status"] == "Canceled" ? "selected" : ""; ?> value="Canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="scheduleTime" class="form-label">Scheduled time</label>
                        <input name="scheduleTime"  id="scheduleTime" value="<?php echo $campaign["schedule_time"]; ?>" class="form-control flatpickr flatpickr-input" type="text" >
                    </div>
                    <div class="col-md-12">
                        <button name="updateCampaign" type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>