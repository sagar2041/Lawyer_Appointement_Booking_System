<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
include("../auth/header.php");
include("../auth/sidebar.php");
?>
<link rel="stylesheet" href="popup_style.css">
<div class="page-content">
    <?php
    if (isset($_GET['id'])) {
        ?>
        <div class="popup popup--icon -question js_question-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Sure</h3>
                <p>Are You Sure To Delete This Record?</p>
                <p></p>
                <p>
                    <a href="delete_lawyer.php?id=<?php echo $_GET['id']; ?>" class="btn btn-success" data-for="js_success-popup">Yes</a>
                    <a href="lawyer_data.php" class="btn btn-danger" data-for="js_success-popup">No</a>
                </p>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Available Lawyers</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <!-- <th>DOB</th> -->
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Type</th>
                                    <th>Fees</th>
                                    <!-- <th>Action</th> -->
                                    <!-- <th></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection1.php';
                                $sql = "SELECT * FROM lawyers";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_array()) {
                                        ?>
                                        <tr>
                                            <td class="sorting_1"><?= $row['id']; ?></td>
                                            <td class="sorting_1"><?= $row['name']; ?></td>
                                            <td class="sorting_1"><?= $row['gender']; ?></td>
                
                                            <td class="sorting_1"><?= $row['email']; ?></td>
                                            <td class="sorting_1"><?= $row['mobile']; ?></td>
                                            <td class="sorting_1"><?= $row['lawyer_type']; ?></td>
                                            <td class="sorting_1"><?= $row['fees']; ?></td>
                                             
                                            
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "sql error" . $sql . "<br>" . $conn->error;
                                }
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("../auth/footer.php");
?>
