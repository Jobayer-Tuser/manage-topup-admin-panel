<?php
use App\Models\Eloquent;
$eloquent = Eloquent::getInstance();

if(isset($_POST['updateGroup'])){
    $tableName = "contact_groups";
    $columnValue["contact_group_name"] = $_POST['groupName'];
    $columnValue["contact_group_description"] = $_POST['groupDesc'];
    $whereValue["id"] = $_POST['groupId'];
    $isUpdated = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}
## ===*=== [F]ETCH GROUP DATA ===*=== ##
if(isset($_GET['eid'])){
    $columnName = "*";
    $tableName = "contact_groups";
    $whereValue["id"] = $_GET["eid"];
    $group = $eloquent->selectData($columnName, $tableName, @$whereValue);
    $group = $group[0];
}


$columnName = "*";
$tableName = "contact_groups";
$contacts = $eloquent->selectData($columnName, $tableName);

?>
<div class="row layout-top-spacing">
    <div id="flLoginForm" class="col-lg-12 layout-spacing">
    <?php
    #== REGISTRATION CONFIRMATION MESSAGE
    if(isset($_POST['updateGroup']))
    {
        if($isUpdated > 0) {
            echo notification("success", "Group udpate successfully.");
        } else {
            echo notification("danger", "Something went wrong please recheck!");
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
                    <input type="hidden" name="groupId" value="<?php echo $group["id"] ?>"/>
                    <div class="col-md-4">
                        <label for="groupName" class="form-label">Contact Group Name</label>
                        <input name="groupName" value="<?php echo $group["contact_group_name"] ?>" type="text" class="form-control" id="groupName" placeholder="Enter contact group name" required />
                    </div>
                    <div class="col-md-8">
                        <label for="groupDesc" class="form-label">Contact Group Description</label>
                        <textarea name="groupDesc" class="form-control" id="groupDesc" placeholder="Enter group description" required ><?php echo $group["contact_group_description"] ?></textarea>
                    </div>
                    
                    <div class="col-md-12">
                        <button name="updateGroup" type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>