<?php
use App\Models\Database;
$eloquent = Database::getInstance();

if(isset($_POST['saveNewAdmin'])){
    if(!empty($_POST['adminName']) && !empty($_POST['adminEmail']) && !empty($_POST['adminPass']) && !empty($_POST['adminStatus'])){
        $tableName = "admins";
        $columnValue["admin_name"]   = $_POST['adminName'];
        $columnValue["admin_email"]  = $_POST['adminEmail'];
        $columnValue["admin_pass"]   = bcrypt($_POST['adminPass']);
        $columnValue["admin_status"] = $_POST['adminStatus'];
        $registerUser = $eloquent->insertData($tableName, $columnValue);
    }
}

# DELETE ADMIN DATA #
if (isset($_POST['deleteAdmin'])){
    $tableName = "admins";
    $whereValue["id"] = $_POST['del_admin'];
    $queryResult = $eloquent->deleteData($tableName, $whereValue);
}

$columnName = "*";
$tableName = "admins";
$adminList = $eloquent->selectData($columnName, $tableName);

?>
<div class="row layout-top-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['saveNewAdmin']))
    {
        if($registerUser > 0)
        {
            echo notification("success", "New admin user save successfully");
        } else {
            echo notification("danger", "Something went wrong Cannot save admin please recheck");
        }
    }
    ?>
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Add Admin</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="row g-3" action="" method="POST">
                    <div class="col-md-6">
                        <label for="adminName" class="form-label">Full Name</label>
                        <input name="adminName" type="text" class="form-control" id="adminName" placeholder="Enter your full name" required />
                    </div>
                    <div class="col-md-6">
                        <label for="adminEmail" class="form-label">Email</label>
                        <input name="adminEmail" type="email" class="form-control" id="adminEmail" placeholder="Enter your email" required />
                    </div>
                    <div class="col-md-6">
                        <label for="adminPass" class="form-label">Password</label>
                        <input name="adminPass" type="password" class="form-control " id="adminPass" placeaholder="Enter your password" required />
                    </div>
                    <div class="col-md-6">
                        <label for="adminStatus" class="form-label">Status</label>
                        <select name="adminStatus" id="adminStatus" class="form-select">
                            <option value="" selected>Select a status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button name="saveNewAdmin" type="submit" class="btn btn-success float-end">Save</button>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="15%" >Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($adminList) && is_array($adminList)){
                            foreach ($adminList as $eachAdmin){
                                $status = ($eachAdmin['admin_status'] == "Active") ? "success" : "dark";
                                $admins = <<<EOD
                                    <tr>
                                    <td>{$eachAdmin['admin_name']}</td>
                                    <td>{$eachAdmin['admin_email']}</td>
                                    <td><span class="badge outline-badge-{$status} mb-2 me-4">{$eachAdmin['admin_status']}</span></td>
                                    <td>
                                        <a href="edit-admin.php?eid={$eachAdmin['id']}" class="btn btn-warning btn-sm mb-2 _effect--ripple waves-effect waves-light">
                                        Edit</a>
                                        <button id="del_Admin" data-did="{$eachAdmin['id']}" data-name="{$eachAdmin['admin_name']}" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#deleteAdminModal">
                                        Delete</button>
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