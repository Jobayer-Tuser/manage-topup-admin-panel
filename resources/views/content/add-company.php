<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

if(isset($_POST['saveNewCompany'])){
    if(!empty($_POST['companyName']) && !empty($_POST['companyAddress']) && !empty($_POST['companyWebsite'])){
        $tableName = "client_company";
        $columnValue["company_name"]   = $_POST['companyName'];
        $columnValue["company_address"]   = $_POST['companyAddress'];
        $columnValue["company_website"]   = $_POST['companyWebsite'];
        $registerCompany = $eloquent->insertData($tableName, $columnValue);
    }
}

# DELETE COMPANY DATA #
if (isset($_POST['del_Company'])){
    $tableName = "client_company";
    $whereValue["id"] = $_POST['delCompID'];
    $isDeleted = $eloquent->deleteData($tableName, $whereValue);
}

# FETCH COMPANY DATA #
$columnName = "*";
$tableName = "client_company";
$companies = $eloquent->selectData($columnName, $tableName);

?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
        <?php
        #== REGISTRATION CONFIRMATION MESSAGE
        if(isset($_POST['del_Company']))
        {
            if($isDeleted > 0) {
                echo notification("success", "Company deleted successfully");
            } else if ($registerCompany > 0) {
                echo notification("success", "New company save successfully");
            } else {
                echo notification("danger", "Something went wrong please recheck");
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
                    <div class="col-md-4">
                        <label for="companyName" class="form-label">Company Name</label>
                        <input name="companyName" type="text" class="form-control" id="companyName" placeholder="Enter company name" required />
                    </div>
                    <div class="col-md-4">
                        <label for="companyAddress" class="form-label">Company Address</label>
                        <input name="companyAddress" type="text" class="form-control" id="companyAddress" placeholder="Enter company address" required />
                    </div>
                    <div class="col-md-4">
                        <label for="companyWebsite" class="form-label">Company Website</label>
                        <input name="companyWebsite" type="text" class="form-control" id="companyWebsite" placeholder="Enter company website" required />
                    </div>

                    <div class="col-md-12">
                        <button name="saveNewCompany" type="submit" class="btn btn-success float-end">Save</button>
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
                    <th>Address</th>
                    <th>Website</th>
                    <th width="15%" >Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($companies) && is_array($companies)){
                    foreach ($companies as $eachCompany){
                        echo <<<EOD
                                    <tr>
                                    <td>{$eachCompany['company_name']}</td>
                                    <td>{$eachCompany['company_address']}</td>
                                    <td>{$eachCompany['company_website']}</td>
                                    <td>
                                        <a href="edit-company.php?eid={$eachCompany['id']}" class="btn btn-warning btn-sm mb-2 _effect--ripple waves-effect waves-light">Edit</a>
                                        <form action="" method="post">
                                            <input type="hidden" name="delCompID" value="{$eachCompany['id']}"/>
                                            <button name="del_Company" type="submit" id="del_company" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light">Delete</button>
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