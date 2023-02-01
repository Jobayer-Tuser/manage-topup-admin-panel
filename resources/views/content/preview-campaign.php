<?php
use App\Models\Database;
use App\Http\Controllers\CampaignController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

$eloquent = Database::getInstance();
$reader = new Xlsx();
$campaignCtrl = new CampaignController();

if(isset($_POST["createCampaign"])){

    $lotId = rand();
    $presentDate = date("Y-m-d H:i:s");
    $createDate = date("F jS, Y", strtotime($presentDate));
    $scheduleTime = date("F jS, Y", strtotime($_POST["scheduleTime"]));

    $campaign = [
        "lotId"         => $lotId,
        "scheduleTime"  => !empty($_POST["scheduleTime"]) ? $_POST["scheduleTime"] : $presentDate,
        "campTitle"     => $_POST["campaignTitle"],
        "serviceType"   => $_POST["campaignType"],
        "createDate"    => $presentDate,
    ];

    if(isset($_FILES['contactFile']) && !empty($_FILES["contactFile"])){
        try {
            $spreadsheet = $reader->load($_FILES['contactFile']["tmp_name"]);
            $contactDetails = $spreadsheet->getActiveSheet()->toArray();
            unset($contactDetails[0]);
            $camp = $campaignCtrl->saveTempCampaignDataFromExcel(campaign: $campaign, contacts: $contactDetails);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    if(isset($_POST["contactGroup"]) && !empty($_POST["contactGroup"])){
        $columnName = "*";
        $tableName = "contact_lists";
        $whereValue["contact_group_id"] = $_POST["contactGroup"];
        $contactGroupWise = $eloquent->selectData($columnName, $tableName, @$whereValue);
        $camp2 = $campaignCtrl->saveTempCampaignDataFromContactGroup(campaign: $campaign, contacts: $contactGroupWise);
    }
}

$columnName = "*";
$tableName = "temp_campaign_process_logs";
$processLogs = $eloquent->selectData($columnName, $tableName);
?>

<div class="row layout-top-spacing">
    <form action="add-campaign.php" method="POST">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Preview Campaign</h4>
                    </div>
                </div>
                <?php
                echo <<<EOD
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                            <h4>Title : {$processLogs[0]["campaign_title"]}</h4>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                            <h4>Lot ID : {$processLogs[0]["campaign_lot_id"]}</h4>
                            <input type="hidden" name="campaignLotId" value="{$processLogs[0]["campaign_lot_id"]}"/>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                            <h4>Service type : {$processLogs[0]["service_type"]}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                            <h4>Created On : {$createDate} </h4>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                            <h4>Schedule Time : {$scheduleTime}</h4>
                            <input type="hidden" name="scheduleTime" value="{$_POST["scheduleTime"]}"/>
                        </div>                  
                    </div>
                EOD;
                ?>
            </div>
            <div class="widget-content widget-content-area">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Contact Number</th>
                        <th style="width: 100px">Operator</th>
                        <th>Contact type</th>
                        <th>Balance</th>
                        <th style="width: 15px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($processLogs) && !empty($processLogs)){
                        foreach ($processLogs as $key => $eachLog){

                            $gpSelected = $eachLog["contact_operator"] == "GP" ? "selected" : "";
                            $skittoSelected = $eachLog["contact_operator"] == "GP ST" ? "selected" : "";
                            $rbSelected = $eachLog["contact_operator"] == "RB" ? "selected" : "";
                            $ttSelected = $eachLog["contact_operator"] == "TT" ? "selected" : "";
                            $blSelected = $eachLog["contact_operator"] == "BL" ? "selected" : "";

                            $prepaidSelected = $eachLog["contact_type"] == "Prepaid" ? "selected" : "";
                            $postpaidSelected = $eachLog["contact_type"] == "Postpaid" ? "selected" : "";

                            echo <<<EOD
                                <tr id="contactRowNum{$key}">
                                    <td><input name="contactNum" data-nid="{$eachLog['id']}" type="text" class="form-control number" value="{$eachLog["contact_number"]}" disabled/></td>
                                    <td>
                                        <select data-oid="{$eachLog["id"]}" name="operator" class="form-control operator" disabled>
                                            <option {$gpSelected} value="GP">GP</option>
                                            <option {$skittoSelected} value="GP ST">GP ST</option>
                                            <option {$rbSelected} value="RB">RB</option>
                                            <option {$ttSelected} value="TT">TT</option>
                                            <option {$blSelected} value="BL">BL</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select data-cid="{$eachLog["id"]}" name="contactType" class="form-control contactType" disabled>
                                            <option {$prepaidSelected} value="Prepaid">Prepaid</option>
                                            <option {$postpaidSelected} value="Postpaid">Postpaid</option>
                                        </select>   
                                    </td>
                                    <td><input name="balance" type="text" class="form-control changeBalance" data-logid="{$eachLog['id']}" value="{$eachLog["balance"]}" disabled /></td>
                                    <td>
                                        <button id="editContactRow{$key}" data-eid="{$key}" type="button" class="btn btn-warning btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light editContactRow">Edit</button>
                                        <button id="deleteContactRow{$key}" data-ldid="{$eachLog['id']}" data-did="{$key}" type="submit" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light deleteContactRow">Delete</button>
                                    </td>
                                </tr>
                            EOD;
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <div class="col-md-12">
                    <button name="processCampaign" type="submit" class="btn btn-success float-end mb-2">Process Campaign</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<script type="text/javascript">
    $(function () {

        $(".operator").change(function(e){

            let logId = $(this).data("oid");
            let operator = $(this).val();

            $.ajax({
                type: "POST",
                url: "ajax-request.php",
                data: {
                    change_operator : "YES",
                    log_id : logId,
                    operator : operator,
                },
                success: function(response){
                    if (response == "Success"){}
                }
            });
        });

        $(".contactType").change(function(e){

            let logId = $(this).data("cid");
            let contact_type = $(this).val();

            $.ajax({
                type: "POST",
                url: "ajax-request.php",
                data: {
                    change_type : "YES",
                    log_id : logId,
                    contact_type : contact_type,
                },
                success: function(response){
                    if (response == "Success"){}
                }
            });
        });


        //Table row will remove button is clicked
        $(document).on('click', '.deleteContactRow', function(e){
            e.preventDefault();

            let buttonId = $(this).data("did");
            let logDId = $(this).data("ldid");

            $.ajax({
                type: "POST",
                url: "ajax-request.php",
                data: {
                    delete_log : "YES",
                    del_log_id : logDId,
                },
                success: function(response){
                    if (response == "Success"){
                        $('#contactRowNum' + buttonId).remove();
                    }
                }
            });

        });

        // remove the disabled attribute once button is clicked
        $(document).on('click', '.editContactRow', function(e){
            e.preventDefault();
            let buttonId = $(this).data("eid");
            $("#contactRowNum" + buttonId + " td input," + "#contactRowNum" + buttonId + " td select" ).removeAttr("disabled");
        });

        // update balance on ajax call
        $(".changeBalance").keyup(function(e){
            e.preventDefault();

            let logId = $(this).data("logid");
            let balanceToUpdate = $(this).val();

            $.ajax({
                type: "POST",
                url: "ajax-request.php",
                data: {
                    change_balance : "YES",
                    log_id : logId,
                    balanceToUpdate : balanceToUpdate,
                },
                success: function(response){
                    if (response == "Success"){}
                }
            });
        });

        // update number on ajax call
        $(".number").keyup(function(e){
            e.preventDefault();

            let logId = $(this).data("nid");
            let number = $(this).val();

            $.ajax({
                type: "POST",
                url: "ajax-request.php",
                data: {
                    change_number : "YES",
                    log_id : logId,
                    number : number,
                },
                success: function(response){
                    if (response == "Success"){}
                }
            });
        });
    });
</script>
