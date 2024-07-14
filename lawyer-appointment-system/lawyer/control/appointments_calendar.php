<?php
ob_start(); // Start output buffering
session_start();
include("../auth/header.php");
include("../auth/sidebar.php");

include 'connection1.php';

// Highlight Today's Date
$current_date = date('Y-m-d');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = $_POST['client_name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['appointment_date'] . ' ' . $_POST['start_time'];
    $end_date = $_POST['appointment_date'] . ' ' . $_POST['end_time'];

    $insertSql = "INSERT INTO appointments(client_name, title, start, end, description) VALUES('$client_name', '$title', '$start_date', '$end_date', '$description')";
    $stmt = $conn->prepare($insertSql);
    $stmt->execute();
    $stmt->close();

    // Set session variable for success message
    $_SESSION['appointment_added'] = true;

    // Redirect to the same page to avoid resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch appointments from the database
$result = mysqli_query($conn, 'SELECT * FROM appointments');
$appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Extract appointment dates for highlighting
$appointmentDates = array_map(function($appointment) {
    return [
        'date' => date('Y-m-d', strtotime($appointment['start'])),
        'details' => [
            'client_name' => $appointment['client_name'],
            'title' => $appointment['title'],
            'start' => $appointment['start'],
            'end' => $appointment['end'],
            'description' => $appointment['description']
        ]
    ];
}, $appointments);

// Fetch case-related appointments for the lawyer from the case_register table
$lawyer_id = $_SESSION['id']; // Assuming lawyer ID is stored in session
$query = "SELECT filling_date, title, client_name, description FROM case_register WHERE lawyer_name = $lawyer_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $filling_date = $row['filling_date'];
    $appointment_date = date('Y-m-d', strtotime($filling_date . ' + 3 days'));
    $client_id = $row['client_name'];
    $clientQuery = "SELECT name FROM clients WHERE id = $client_id";
    $client_result = mysqli_query($conn, $clientQuery);
    $client_data = mysqli_fetch_assoc($client_result);
    $appointmentDates[] = [
        'date' => $appointment_date,
        'details' => [
            'client_name' => $client_data['name'], // Assuming the client's name can be derived from clients table
            'title' => $row['title'],
            'start' => $appointment_date . ' 00:00:00', // Assuming all-day event
            'end' => $appointment_date . ' 23:59:59', // Assuming all-day event
            'description' => $row['description'] . ' - Client: ' . $client_data['name']
        ]
    ];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add CSS styles for the calendar here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }
        .calendar-container {
            max-width: 800px;
            margin-top: 100px;
            width: 150vh;
            height: 70vh;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .calendar-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .calendar-header select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f0f0f0;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        .calendar-day {
            padding: 10px;
            text-align: center;
            background-color: #f0f0f0;
            border-radius: 5px;
            position: relative;
        }
        .calendar-day.today {
            background-color: #4CAF50; /* Change this to the desired color */
        }
        .calendar-day.has-appointment {
            background-color: #007BFF;
            color: white;
        }
        .calendar-day:hover {
            background-color: #d0eaff;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        /* Tooltip for appointment details */
        .tooltip {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            white-space: nowrap;
            text-align: left;
        }
        .calendar-day:hover .tooltip {
            display: block;
        }
        /* Success message style */
        .success-message {
            display: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }
        /* Button styles */
        .modal-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="calendar-header">
            <h2>Appointments Calendar</h2>
            <div>
                <select id="month-select"></select>
                <select id="year-select"></select>
            </div>
        </div>
        <div class="success-message" id="success-message">
            Appointment successfully added!
        </div>
        <div class="calendar" id="calendar"></div>
    </div>

    <!-- Modal structure -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
            <form id="appointmentForm" method="post" action="">
                <center><h4>Appointment Details</h4></center><br>
                <input type="hidden" id="appointment-date" name="appointment_date">
                <div>
                    <label for="client_name">Client Name:</label>
                    <input type="text" id="client_name" name="client_name" required>
                </div><br>
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div><br>
                <div>
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="start_time" required>
                </div><br>
                <div>
                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="end_time" required>
                </div><br>
                <div>
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" required>
                </div><br>
                <div class="modal-buttons">
                    <center><button type="submit">Add Appointment</button>
                    <button type="button" id="view-appointments">View Appointments</button></center>
                </div>
            </form>
        </div>
    </div>

    <!-- View Appointments Modal structure -->
    <div id="viewAppointmentsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="view-modal-body"></div>
        </div>
    </div>

    <script>
        const monthSelect = document.getElementById('month-select');
        const yearSelect = document.getElementById('year-select');
        const calendar = document.getElementById('calendar');
        const modal = document.getElementById('appointmentModal');
        const viewAppointmentsModal = document.getElementById('viewAppointmentsModal');
        const closeModal = document.querySelector('.modal-content .close');
        const closeViewModal = viewAppointmentsModal.querySelector('.close');
        const successMessage = document.getElementById('success-message');

        // Populate months and years in select dropdowns
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const currentYear = new Date().getFullYear();
        for (let i = 0; i < months.length; i++) {
            const option = document.createElement('option');
            option.text = months[i];
            option.value = i + 1;
            monthSelect.add(option);
        }
        for (let i = currentYear - 40; i <= currentYear + 10; i++) {
            const option = document.createElement('option');
            option.text = i;
            option.value = i;
            yearSelect.add(option);
        }

        // Generate calendar
        function generateCalendar(month, year) {
            calendar.innerHTML = '';
            const daysInMonth = new Date(year, month, 0).getDate();
            const firstDay = new Date(year, month - 1, 1).getDay();

            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('calendar-day');
                calendar.appendChild(emptyDay);
            }

            const appointmentDates = <?php echo json_encode($appointmentDates); ?>;

            for (let i = 1; i <= daysInMonth; i++) {
                const calendarDay = document.createElement('div');
                calendarDay.classList.add('calendar-day');
                calendarDay.textContent = i;
                calendarDay.dataset.date = `${year}-${month.toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;

                // Highlight today's date
                const today = new Date();
                const todayDateString = `${today.getFullYear()}-${(today.getMonth() + 1).toString().padStart(2, '0')}-${today.getDate().toString().padStart(2, '0')}`;
                if (calendarDay.dataset.date === todayDateString) {
                    calendarDay.classList.add('today');
                }

                // Highlight days with appointments
                const appointment = appointmentDates.find(appointment => appointment.date === calendarDay.dataset.date);
                if (appointment) {
                    calendarDay.classList.add('has-appointment');

                    // Add tooltip for appointment details
                    const tooltip = document.createElement('div');
                    tooltip.classList.add('tooltip');
                    tooltip.innerHTML = `
                        <strong>Client:</strong> ${appointment.details.client_name}<br>
                        <strong>Title:</strong> ${appointment.details.title}<br>
                        <strong>Start:</strong> ${new Date(appointment.details.start).toLocaleTimeString()}<br>
                        <strong>End:</strong> ${new Date(appointment.details.end).toLocaleTimeString()}<br>
                        <strong>Description:</strong> ${appointment.details.description}
                    `;
                    calendarDay.appendChild(tooltip);
                }

                calendar.appendChild(calendarDay);

                calendarDay.addEventListener('click', () => showAppointments(calendarDay.dataset.date));
            }
        }

        // Show appointments for a date
        function showAppointments(date) {
            const modalBody = document.getElementById('modal-body');
            const appointmentDateInput = document.getElementById('appointment-date');
            const viewAppointmentsButton = document.getElementById('view-appointments');

            modalBody.innerHTML = '';
            appointmentDateInput.value = date;
            modal.style.display = 'block';

            viewAppointmentsButton.onclick = () => {
                showAppointmentsModal(date);
            };
        }

        // Show appointments modal for a date
        function showAppointmentsModal(date) {
            const viewModalBody = document.getElementById('view-modal-body');
            const appointmentDates = <?php echo json_encode($appointmentDates); ?>;
            const appointments = appointmentDates.filter(appointment => appointment.date === date);

            viewModalBody.innerHTML = `<h4>Appointments on ${date}</h4>`;
            if (appointments.length > 0) {
                appointments.forEach(appointment => {
                    viewModalBody.innerHTML += `
                        <p><strong>Client:</strong> ${appointment.details.client_name}<br>
                        <strong>Title:</strong> ${appointment.details.title}<br>
                        <strong>Start:</strong> ${new Date(appointment.details.start).toLocaleTimeString()}<br>
                        <strong>End:</strong> ${new Date(appointment.details.end).toLocaleTimeString()}<br>
                        <strong>Description:</strong> ${appointment.details.description}</p>
                        <hr>
                    `;
                });
            } else {
                viewModalBody.innerHTML += '<p>No appointments for this day.</p>';
            }

            viewAppointmentsModal.style.display = 'block';
        }

        // Event listeners for closing the modals
        closeModal.onclick = () => {
            modal.style.display = 'none';
        };

        closeViewModal.onclick = () => {
            viewAppointmentsModal.style.display = 'none';
        };

        // Close modal when clicking outside of the modal content
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            } else if (event.target === viewAppointmentsModal) {
                viewAppointmentsModal.style.display = 'none';
            }
        };

        // Initialize the calendar with the current month and year
        monthSelect.value = new Date().getMonth() + 1;
        yearSelect.value = new Date().getFullYear();
        generateCalendar(monthSelect.value, yearSelect.value);

        // Update calendar when month or year changes
        monthSelect.addEventListener('change', () => {
            generateCalendar(monthSelect.value, yearSelect.value);
        });
        yearSelect.addEventListener('change', () => {
            generateCalendar(monthSelect.value, yearSelect.value);
        });

        // Display success message if an appointment was added
        <?php if (isset($_SESSION['appointment_added']) && $_SESSION['appointment_added']): ?>
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
            <?php unset($_SESSION['appointment_added']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
<?php
include("../auth/footer.php");
?>

