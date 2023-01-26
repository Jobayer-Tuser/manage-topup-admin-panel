<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

if(isset($_POST['saveNewContact'])){
    if(!empty($_POST['groupName']))
    {
        $tableName = "contact_groups";
        $columnValue["contact_group_name"] = $_POST['groupName'];
        $columnValue["contact_group_description"] = $_POST['groupDesc'];
        $registerContact = $eloquent->insertData($tableName, $columnValue);
    }
}

if (isset($_POST['del_contact'])){
    $isDeleted = deleteData("contact_groups", $_POST["delGroupID"]);
}

$columnName = "*";
$tableName = "contact_groups";
$contacts = $eloquent->selectData($columnName, $tableName);

?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['saveNewContact']))
    {
        if(@$registerContact > 0) {
            echo notification("success", "Group save successfully.");
        } else {
            echo notification("danger", "Something went wrong please recheck!");
        }
    }

    # DELETE COMPANY DATA #
    if (isset($_POST['del_group'])) {
        if ($isDeleted == false) {
            echo notification("danger", "Group cannot deleted contain child value.");
        } else{
            echo notification("success", "Group deleted successfully.");
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
                        <label for="groupName" class="form-label">Contact Group Name</label>
                        <input name="groupName" type="text" class="form-control" id="groupName" placeholder="Enter contact group name" required />
                    </div>
                    <div class="col-md-8">
                        <label for="groupDesc" class="form-label">Contact Group Description</label>
                        <textarea name="groupDesc" class="form-control" id="groupDesc" placeholder="Enter group description" required ></textarea>
                    </div>
                    
                    <div class="col-md-12">
                        <button name="saveNewContact" type="submit" class="btn btn-success float-end">Save</button>
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
                    <th>Description</th>
                    <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($contacts) && is_array($contacts)){
                    foreach ($contacts as $eachContact){
                        echo <<<EOD
                        <tr>
                            <td>{$eachContact['contact_group_name']}</td>
                            <td>{$eachContact['contact_group_description']}</td>
                            <td>
                                <a href="edit-contact-group.php?eid={$eachContact['id']}" class="btn btn-warning btn-sm mb-2 _effect--ripple waves-effect waves-light">Edit</a>
                                <form action="" method="post">
                                    <input type="hidden" name="delGroupID" value="{$eachContact['id']}"/>
                                    <button name="del_group" type="submit" id="del_group" class="btn btn-danger btn-sm mb-2 me-6 _effect--ripple waves-effect waves-light">Delete</button>
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