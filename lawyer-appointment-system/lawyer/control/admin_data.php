<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

$now = time();
if ($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

include("../auth/header.php");
include("../auth/sidebar.php");
?>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Table</li>
        </ol>
        <!-- Author Name- Mayuri K. 
        For any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
        Visit website - www.mayurik.com -->
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Admin Data</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $servername = 'localhost';
                                $username = 'root';
                                $password = '';
                                $dbname = "advocate";
                                $conn = mysqli_connect($servername, $username, $password, $dbname);

                                if (!$conn) {
                                    die('Could not connect to MySQL server: ' . mysqli_connect_error());
                                }

                                $sql = "SELECT * FROM admin";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['name']}</td>
                                                <td>{$row['username']}</td>
                                                <td><a href='edit_profile.php?id={$row['id']}'>Edit</a></td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No records found</td></tr>";
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

<?php include("../auth/footer.php"); ?>
