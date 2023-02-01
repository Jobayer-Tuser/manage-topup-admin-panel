<?php
use App\Models\Database;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

$eloquent = Database::getInstance();
$reader = new Xlsx();

if(isset($_POST['saveNewContactList'])){
    if(!empty($_POST['contactNumber']) && !empty($_POST['contactGroupId']) && !empty($_POST['contactOperator']))
    {
        $tableName = "contact_lists";
        $columnValue["contact_group_id"] = $_POST['contactGroupId'];
        $columnValue["contact_number"] = $_POST['contactNumber'];
        $columnValue["contact_operator"] = $_POST['contactOperator'];
        $columnValue["contact_type"] = $_POST['contactType'];
        $registerContactList = $eloquent->insertData($tableName, $columnValue);
    }
}

if (isset($_POST["saveNewContactExcel"])){
    try {
        $spreadsheet = $reader->load($_FILES['contactExcel']["tmp_name"]);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        unset($sheetData[0]);
        foreach ($sheetData as $eachContact){
            $tableName = "contact_lists";
            $columnValue["contact_group_id"] = $_POST['contactGroupId'];
            $columnValue["contact_number"] = $eachContact[0];
            $columnValue["contact_operator"] = $eachContact[1];
            $columnValue["contact_type"] = $eachContact[2];
            $registerContactExcel = $eloquent->insertData($tableName, $columnValue);
        }


    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

if (isset($_POST['del_contact'])){
    $isDeleted = deleteData("contact_lists", $_POST["delContactID"]);
}

# FETCH GROUP DATA #
$columnName = $tableName = $whereValue = null;
$tableName = "contact_groups";
$columnName["1"] = "id";
$columnName["2"] = "contact_group_name";
$contactGroups = $eloquent->selectData($columnName, $tableName);

# FETCH CLIENT DATA #
$columnName = $tableName = $joinType = $onCondition = null;
$columnName["1"] = "contact_lists.contact_group_id";
$columnName["2"] = "contact_lists.contact_number";
$columnName["3"] = "contact_lists.contact_operator";
$columnName["4"] = "contact_lists.contact_type";
$columnName["5"] = "contact_groups.contact_group_name";
$columnName["6"] = "contact_lists.id";
$tableName["MAIN"] = "contact_lists";
$joinType = "INNER";
$tableName["1"] = "contact_groups";
$onCondition["1"] = ["contact_groups.id", "contact_lists.contact_group_id"];
$contactList = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, /*@$whereValue, @$formatBy*/);

?>
<div class="row layout-top-spacing">
        <?php
        #== REGISTRATION CONFIRMATION MESSAGE
        if(isset($_POST['saveNewContactList']) || isset($_POST["saveNewContactExcel"]))
        {
            if($registerContactList > 0 || $registerContactExcel > 0) {
                echo notification("success", "New contact save successfully");
            } else {
                echo notification("danger", "Something went wrong Cannot save contact please recheck");
            }
        }

        # DELETE CONTACT DATA #
        if (isset($_POST['del_contact'])){
            if($isDeleted == true){
                echo notification("success", "Contact deleted successfully");
            } else{
                echo notification("danger", "Something went wrong Cannot delete contact please recheck");
            }
        }
        ?>
    <div id="flLoginForm" class="col-md-6 layout-spacing">
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
                    <div class="col-md-12">
                        <label for="contactGroupId" class="form-label">Contact Groups</label>
                        <select name="contactGroupId" id="contactGroupId" class="form-select">
                            <option value="" selected>Select a Group</option>
                            <?php
                            if(!empty($contactGroups)){
                                foreach ($contactGroups as $eachContactGroup){
                                 echo <<<EOD
                                        <option value="{$eachContactGroup["id"]}">{$eachContactGroup["contact_group_name"]}</option>  
                                  EOD;
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input name="contactNumber" type="text" class="form-control" id="contactNumber" placeholder="Enter contact number" required />
                    </div>
                    <div class="col-md-12">
                        <label for="contactOperator" class="form-label">Contact Operator</label>
                        <select name="contactOperator" id="contactOperator" class="form-select">
                            <option value="" selected>Select a Operator</option>
                            <option value="GP">Grameenphone</option>
                            <option value="BL">Banglalink</option>
                            <option value="RB">Robi</option>
                            <option value="TT">Teletalk</option>
                            <option value="GP ST">Skitto</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="contactType" class="form-label">Contact Type</label>
                        <select name="contactType" id="contactType" class="form-select">
                            <option value="" selected>Select a Type</option>
                            <option value="Prepaid">Prepaid</option>
                            <option value="Postpaid">Postpaid</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <button name="saveNewContactList" type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="flLoginForm" class="col-md-6 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><?php echo pageTitle(); ?></h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="row g-3" action="" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label for="contactGroupId" class="form-label">Contact Groups</label>
                        <select name="contactGroupId" id="contactGroupId" class="form-select">
                            <option value="" selected>Select a Group</option>
                            <?php
                            if(!empty($contactGroups)){
                                foreach ($contactGroups as $eachContactGroup){
                                    echo <<<EOD
                                        <option value="{$eachContactGroup["id"]}">{$eachContactGroup["contact_group_name"]}</option>  
                                  EOD;
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="contactExcel" class="form-label">Contact Number</label>
                        <input name="contactExcel" type="file" class="form-control" id="contactExcel" required />
                    </div>
                    <div class="col-md-4">
                        <a href="public/uploads/contacts/contacts-demo.xlsx" class="btn btn-info" style="margin-top: 36px">Download Example</a>
                    </div>
                    <p class="help-block note text-info"><i><strong>Note: File should be XLS or XLSX and Maximum Record : 5000, Max File Size : 1MB</strong></i></p>
                    <div class="col-md-12">
                        <button name="saveNewContactExcel" type="submit" class="btn btn-success float-end">Save</button>
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
                    <th>Group Name</th>
                    <th>Contact Number</th>
                    <th>Contact Operator</th>
                    <th>Contact Type</th>
                    <th style="min-width: 15px">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($contactList) && is_array($contactList)){
                    foreach ($contactList as $eachContact){
                        echo <<<EOD
                        <tr>
                            <td>{$eachContact['contact_group_name']}</td>
                            <td>{$eachContact['contact_number']}</td>
                            <td>{$eachContact['contact_operator']}</td>
                            <td>{$eachContact['contact_type']}</td>
                            <td>
                                <a href="edit-contact.php?eid={$eachContact['id']}" class="btn btn-warning btn-sm mb-2 _effect--ripple waves-effect waves-light">Edit</a>
                                <form action="" method="post">
                                    <input type="hidden" name="delContactID" value="{$eachContact['id']}"/>
                                    <button name="del_contact" type="submit" id="del_contact" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light">Delete</button>
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

<!-- Delete Admin Modal -->
<div class="modal fade modal-notification" id="deleteAdminModal" tabindex="-1" role="dialog" aria-labelledby="deleteAdminModal" aria-hidden="true">
    <div class="modal-dialog" role="document" id="deleteAdminModal">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="del_admin" />
                <div class="modal-body text-center">
                    <div class="icon-content">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    </div>
                    <p class="modal-text">Do you realy want to delete <strong class="admin_name"></strong>!</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light-dark" data-bs-dismiss="modal">Cancel</button>
                    <button name="deleteAdmin" type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(document).on('click', '#del_Admin', function(e){
            let name  = $(this).data('name');
            let id    = $(this).data('did');

            $('.admin_name').text(name);
            $('[name="del_admin"]').val(id);
        })
    });
</script>