<?php 
include("../auth/header.php");
include("../auth/sidebar.php");
?>
<div class="page-content">

    <!--  Author Name- Mayuri K. 
    for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
    Visit website - www.mayurik.com -->

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Legal Acts</h6>
                    
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Act Name</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection1.php';
                                $sql = "SELECT * FROM legal_acts";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_array()) {
                                ?>
                                    <tr>
                                        <td class="sorting_1"><?= $row['id']; ?></td>
                                        <td class="sorting_1"><?= $row['act_name']; ?></td>
                                        <td class="sorting_1"><?= ($row['status'] == "0") ? "Active" : "Inactive"; ?></td>
                                        <td><a href="delete_act.php?id=<?= $row['id']; ?>">Delete</a></td>
                                        <td><a href="edit_act.php?id=<?= $row['id']; ?>">Edit</a></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == "0") {
                                                echo "<a href='deactivate_act.php?id=".$row['id']."' class='btn btn-danger'>Deactivate</a>";
                                            } else {
                                                echo "<a href='activate_act.php?id=".$row['id']."' class='btn btn-success'>Activate</a>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "SQL error: " . $sql . "<br>" . $conn->error;
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

    <!-- partial:../../partials/_footer.html -->
    <!-- partial -->

</div>

<!--  Author Name- Mayuri K. 
for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
Visit website - www.mayurik.com -->
<?php 
include("../auth/footer.php");
?>
