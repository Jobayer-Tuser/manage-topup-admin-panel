<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

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
        if (isset($_POST["del_campaign"])){
            if($isDeleted == true){
                echo notification("success", "New campaign deleted successfully");
            } else{
                echo notification("danger", "Something went wrong Cannot delete campaign please recheck");
            }
        }
        ?>
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

<!--        <td>-->
<!--            <form action="" method="post">-->
<!--                <input type="hidden" name="delCampID" value="{$eachCampaign['id']}"/>-->
<!--                <button name="del_campaign" type="submit" id="del_campaign" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light">Delete</button>-->
<!--            </form>-->
<!--        </td>-->