<?php
use App\Models\Database;
use App\Http\Controllers\CampaignController;

$campCtrl = new CampaignController();
$eloquent = Database::getInstance();

if(isset($_POST["processCampaign"])){

    $addValueToCampaignProcessor = $campCtrl->insertDataToCampaignProcessor($_POST['campaignLotId']);
    $addValueToCampaignList = $campCtrl->insertDataToCampaignList($_POST["campaignLotId"]);
    $deleteTempData = $campCtrl->deleteAllDataFromTempCampaignTable($_POST["campaignLotId"]);
}

$tableName = $columnName = $columnValue = null;
$columnName["1"] = "id";
$columnName["2"] = "contact_group_name";
$tableName = "contact_groups";
$contactGroups = $eloquent->selectData($columnName, $tableName);

?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['processCampaign']))
    {
        if($addValueToCampaignProcessor > 0)
        {
            echo notification("success", "Campaign save successfully");
        } else {
            echo notification("danger", "Something went wrong Cannot save campaign please recheck");
        }
    }
    ?>
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row mb-4">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Create Campaign</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="row g-3" action="preview-campaign.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="campaignType" class="col-sm-2 col-form-label">Campaign Type</label>
                        <div class="col-sm-10">
                            <select name="campaignType" id="campaignType" class="form-select">
                                <option value="" selected>Select a service</option>
                                <option value="Balance">Balance</option>
                                <option value="Combo Offer">Combo Offer</option>
                                <option value="Talk Time">Talk Time</option>
                                <option value="Internet">Internet</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="" class="col-sm-2 col-form-label">Campaign Title</label>
                        <div class="col-md-10">
                            <input name="campaignTitle" type="text" class="form-control" id="campaignTitle" required />
                            <p class="help-block note text-info"><i><strong>Note: Max 80 character !</strong></i></p>
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Select contact from</legend>
                        <div class="col-sm-10">
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input from-excel-file" type="radio" name="contact-from" value="select-from-file" id="form-check-radio-default" checked="">
                                <label class="form-check-label" for="form-check-radio-default">
                                    From File
                                </label>
                            </div>

                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input from-contact-group" type="radio" name="contact-from" value="select-from-group" id="form-check-radio-default" >
                                <label class="form-check-label" for="form-check-radio-default">
                                    Contact list
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row mb-3 upload-from-file">
                        <label for="contactList" class="col-sm-2 col-form-label">Upload Contact List</label>
                        <div class="col-md-4">
                            <input name="contactFile" type="file" class="form-control" id="contactList"/>
                                <p class="help-block note text-info"><i><strong>Note: Upload XLS or XLSX file with max 5000 records</strong></i></p>
                        </div>
                        <div class="col-md-4">
                            <a href="public/uploads/contacts/campaign-contacts.xlsx" class="btn btn-info" style="margin-top: 5px">Download Example</a>
                        </div>
                    </div>

                    <div class="row mb-3 upload-from-group d-lg-none">
                        <label for="contactGroup" class="col-sm-2 col-form-label">Select Groups</label>
                        <div class="col-sm-10">
                            <select name="contactGroup" id="contactGroup" class="form-select">
                                <option value="" selected>Select a service</option>
                                <?php
                                if (!empty($contactGroups) && is_array($contactGroups)){
                                    foreach ($contactGroups as $contactGroup) {
                                        echo <<<EOD
                                            <option value="{$contactGroup["id"]}">{$contactGroup["contact_group_name"]}</option>
                                        EOD;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="scheduleTime" class="col-sm-2 col-form-label">Set campaign time</label>
                        <div class="col-md-10">
                            <input name="scheduleTime" id="scheduleTime" class="form-control date flatpickr" type="text" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button name="createCampaign" type="submit" class="btn btn-success float-end mt-2 _effect--ripple waves-effect waves-light">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $(document).on('click', '.from-contact-group', function(e) {
            $('.upload-from-group').removeClass('d-lg-none');
            $('.upload-from-file').addClass("d-lg-none");
        });

        $(document).on('click', '.from-excel-file', function(e) {
            $('.upload-from-file').removeClass("d-lg-none");
            $('.upload-from-group').addClass('d-lg-none');
        });

    })

</script>

