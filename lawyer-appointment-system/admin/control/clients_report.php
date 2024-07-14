<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
}

include("../auth/header.php");
?>

<?php include("../auth/sidebar.php");?>

<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Client Data</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>DOB</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection1.php';

                                // Fetch client data
                                $clientSql = "SELECT * FROM clients";
                                $clientResult = $conn->query($clientSql);

                                // Fetch case count for each client
                                $caseCountSql = "SELECT client_name, COUNT(*) as case_count FROM case_register GROUP BY Client_name";
                                $caseCountResult = $conn->query($caseCountSql);

                                $caseCounts = [];
                                if ($caseCountResult->num_rows > 0) {
                                    while ($row = $caseCountResult->fetch_assoc()) {
                                        $caseCounts[$row['client_name']] = $row['case_count'];
                                    }
                                }

                                $clients = [];
                                $caseCountArray = [];

                                if ($clientResult->num_rows > 0) {
                                    while ($row = $clientResult->fetch_assoc()) {
                                        $clients[] = $row['name'];
                                        $caseCountArray[] = isset($caseCounts[$row['id']]) ? $caseCounts[$row['id']] : 0;
                                        ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['gender']; ?></td>
                                            <td><?= $row['dob']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['mobile']; ?></td>
                                            <td><?= $row['address']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "No clients found.";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <canvas id="clientCasesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../auth/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('clientCasesChart').getContext('2d');
    const data = {
        labels: <?= json_encode($clients); ?>,
        datasets: [{
            label: 'Number of Cases',
            data: <?= json_encode($caseCountArray); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const clientCasesChart = new Chart(ctx, config);
});
</script>
