<?php
session_start();
error_reporting(0);

if(!isset($_SESSION['username'])){
    header('location:login.php');
    exit();
}

include("../auth/header.php");
include 'connection1.php';
include("../auth/sidebar.php");

if(isset($_POST['edit_act'])){
    $sql_query = "UPDATE legel_acts SET act_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("si", $_POST['aname'], $_POST['id']);
    
    if ($stmt->execute()) {
        echo '<link rel="stylesheet" href="popup_style.css">';
        echo '<div class="popup popup--icon -success js_success-popup popup--visible">';
        echo '<div class="popup__background"></div>';
        echo '<div class="popup__content">';
        echo '<h3 class="popup__content__title">Success</h3>';
        echo '<p>Record Updated Successfully</p>';
        echo '<p><script>setTimeout("location.href = \'view_act.php\';", 1500);</script></p>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "SQL Error: " . $conn->error;
    }

    $stmt->close();
}

if(isset($_GET['id'])){
    $uid = $_GET['id']; 
    $sql = "SELECT * FROM legel_acts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_array();
    } else {
        echo "Record not found";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Act</title>
</head>
<body>
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <div class="mb-3">
                            <label for="exampleInputText1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="aname" id="exampleInputText1" value="<?php echo htmlspecialchars($row['act_name']); ?>" placeholder="Enter Act Name">
                        </div>
                        <button class="btn btn-primary" name="edit_act" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>
<?php include("../auth/footer.php"); ?>
</body>
</html>
