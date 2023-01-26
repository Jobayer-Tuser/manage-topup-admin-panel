<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

if(isset($_POST['addCampaign'])){
    if(!empty($_POST['campaignT']) && !empty($_POST['serviceType']) && !empty($_POST['totalCNum']) && !empty($_POST['totalRechAmount'])&& !empty($_POST['campaignStat'])){
        $tableName = "campaign_lists";
        $columnValue["campaign_lot_id"] = rand();
        $columnValue["campaign_title"] = $_POST['campaignT'];
        $columnValue["service_type"] = $_POST['serviceType'];
        $columnValue["total_contact_number"] = $_POST['totalCNum'];
        $columnValue["total_recharge_amount"] = $_POST['totalRechAmount'];
        $columnValue["campaign_status"] = $_POST['campaignStat'];
        $columnValue["schedule_time"] = $_POST['scheduleTime'];
        $columnValue["created_at"] = date("Y-m-d H:i:s");
        $registerCampaign = $eloquent->insertData($tableName, $columnValue);
    }
}

if (isset($_POST["del_campaign"])){
    $isDeleted = deleteData("campaign_lists", $_POST["delCampID"]);
}

$columnName = "*";
$tableName = "campaign_lists";
$campaignList = $eloquent->selectData($columnName, $tableName);

?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['addCampaign']))
    {
        if($registerCampaign > 0)
        {
            echo notification("success", "New campaign saved successfully");
        } else {
            echo notification("danger", "Something went wrong Cannot save campaign please recheck");
        }
    }
    if (isset($_POST["del_campaign"])){
        if($isDeleted == true){
            echo notification("success", "New campaign deleted successfully");
        } else{
            echo notification("danger", "Something went wrong Cannot delete campaign please recheck");
        }
    }
    ?>
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
                    <div class="col-md-4">
                        <label for="campaignT" class="form-label">Campaign Title</label>
                        <input name="campaignT" type="text" class="form-control" id="campaignT" placeholder="Enter campaign title" required />
                    </div>
                    <div class="col-md-4">
                        <label for="serviceType" class="form-label">Service Type</label>
                        <select name="serviceType" id="serviceType" class="form-select">
                            <option value="" selected>Select a service</option>
                            <option value="Balance">Balance</option>
                            <option value="Combo Offer">Combo Offer</option>
                            <option value="Talk Time">Talk Time</option>
                            <option value="Internet">Internet</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="totalCNum" class="form-label">Total contact number</label>
                        <input name="totalCNum" type="number" class="form-control" id="totalCNum" placeholder="Total contact number" required />
                    </div>
                    <div class="col-md-4">
                        <label for="totalRechAmount" class="form-label">Total recharge amount</label>
                        <input name="totalRechAmount" type="text" class="form-control" id="totalRechAmount" placeholder="Total recharge amount" required />
                    </div>
                    <div class="col-md-4">
                        <label for="campaignStat" class="form-label">Campaign status</label>
                        <select name="campaignStat" id="campaignStat" class="form-select">
                            <option value="" selected>Select a service</option>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Failed">Failed</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="scheduleTime" class="form-label">Scheduled time</label>
                        <input name="scheduleTime" id="scheduleTime" value="2022-09-19 12:00:00" class="form-control flatpickr flatpickr-input" type="text" placeholder="Select Date and time..">

                    </div>
                    <div class="col-md-12">
                        <button name="addCampaign" type="submit" class="btn btn-success float-end">Save</button>
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
                    <th>Lot ID</th>
                    <th>Campaign Title</th>
                    <th>Service type</th>
                    <th>Total Contact Num</th>
                    <th>Total Recharge amount</th>
                    <th>Schedule time</th>
                    <th>Status</th>
                    <th width="15%" >Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($campaignList) && is_array($campaignList)){
                    foreach ($campaignList as $eachCampaign){
                        $status = ($eachCampaign['campaign_status'] == "Completed") ? "success" : "dark";
                        $admins = <<<EOD
                                    <tr>
                                    <td>{$eachCampaign['campaign_lot_id']}</td>
                                    <td>{$eachCampaign['campaign_title']}</td>
                                    <td>{$eachCampaign['service_type']}</td>
                                    <td>{$eachCampaign['total_contact_number']}</td>
                                    <td>{$eachCampaign['total_recharge_amount']}</td>
                                    <td>{$eachCampaign['schedule_time']}</td>
                                    <td><span class="badge outline-badge-{$status} mb-2 me-4">{$eachCampaign['campaign_status']}</span></td>
                                    <td>
                                        <a href="edit-campaign.php?eid={$eachCampaign['id']}" class="btn btn-warning btn-sm mb-2 _effect--ripple waves-effect waves-light">Edit</a>
                                        <form action="" method="post">
                                            <input type="hidden" name="delCampID" value="{$eachCampaign['id']}"/>
                                            <button name="del_campaign" type="submit" id="del_campaign" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                EOD;
                        echo $admins;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>