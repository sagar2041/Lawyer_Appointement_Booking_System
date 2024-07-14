<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
    exit;
}

include("../auth/header.php");
?>

<?php include("../auth/sidebar.php");?>

<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Lawyer Data</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Lawyer Type</th>
                                    <!-- <th>Status</th> -->
                                    <th>Case Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection1.php';

                                // Fetch lawyer data
                                $lawyerSql = "SELECT * FROM lawyers";
                                $lawyerResult = $conn->query($lawyerSql);

                                // Fetch case count for each lawyer from case_register table
                                $caseCountSql = "SELECT lawyer_name, COUNT(*) as case_count FROM case_register GROUP BY lawyer_name";
                                $caseCountResult = $conn->query($caseCountSql);

                                $caseCounts = [];
                                if ($caseCountResult->num_rows > 0) {
                                    while ($row = $caseCountResult->fetch_assoc()) {
                                        $caseCounts[$row['lawyer_name']] = $row['case_count'];
                                    }
                                }

                                $lawyers = [];
                                $caseCountArray = [];

                                if ($lawyerResult->num_rows > 0) {
                                    while ($row = $lawyerResult->fetch_assoc()) {
                                        $lawyerId = $row['id'];
                                        $lawyerName = $row['name'];
                                        $lawyers[] = $lawyerName;
                                        $caseCountArray[] = isset($caseCounts[$lawyerId]) ? $caseCounts[$lawyerId] : 0;
                                        ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['mobile']; ?></td>
                                            <td><?= $row['lawyer_type']; ?></td>
                                            <!-- <td><?= $row['case_stage'] ?></td> -->
                                            <td><?= isset($caseCounts[$lawyerId]) ? $caseCounts[$lawyerId] : 0; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No lawyers found.</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <canvas id="lawyerCasesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../auth/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('lawyerCasesChart').getContext('2d');
    const data = {
        labels: <?= json_encode($lawyers); ?>,
        datasets: [{
            label: 'Number of Cases',
            data: <?= json_encode($caseCountArray); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const lawyerCasesChart = new Chart(ctx, config);
});
</script>
