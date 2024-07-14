<?php
ob_start(); // Start output buffering
session_start();
include("../auth/header.php");
include("../auth/sidebar.php");
include 'connection1.php';

$client_id = $_SESSION['id']; // Assuming client ID is stored in session

// Fetch appointments from the database
$query = "SELECT filling_date, title, lawyer_name, description FROM case_register WHERE client_name= $client_id";
$result = mysqli_query($conn, $query);

$appointments = array();
while ($row = mysqli_fetch_assoc($result)) {
    $filling_date = $row['filling_date'];
    $appointment_date = date('Y-m-d', strtotime($filling_date . ' + 3 days'));
    $lawyer_id = $row['lawyer_name'];
    $lawyerQuery = "SELECT name FROM lawyers WHERE id=$lawyer_id";
    $lawyer_result = mysqli_query($conn, $lawyerQuery);
    $lawyer_data = mysqli_fetch_assoc($lawyer_result);
    $appointments[$appointment_date][] = [
        'title' => $row['title'],
        'lawyer_name' => $lawyer_data['name'],
        'description' => $row['description']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f7f7f7;
        }
        .calendar-container {
            width: 140vh;
            max-width: 1000px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 66px;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .calendar-header h2 {
            font-size: 24px;
            color: #333;
        }
        .calendar-header select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
            background-color: #f9f9f9;
            border-radius: 4px;
            position: relative;
            transition: background-color 0.3s ease;
        }
        .calendar-day.today {
            background-color: #4caf50;
            color: #fff;
        }
        .calendar-day.has-appointment {
            background-color: #007bff;
            color: #fff;
        }
        .calendar-day:hover {
            background-color: #e0e0e0;
            cursor: pointer;
        }
        .appointments {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .calendar-day:hover .appointments {
            display: block;
            color: black;
        }
        .month-year {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
        }
        .navigation {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .navigation select {
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #ffffff;
            cursor: pointer;
        }
        .navigation select:focus {
            outline: none;
            border-color: #007bff;
        }
        .weekday {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            background-color: #f1f3f4;
            border-radius: 4px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="calendar-header">
            <h2>Appointments Calendar</h2>
            <div class="navigation">
                <select id="selectMonth"></select>
                <select id="selectYear"></select>
            </div>
        </div>
        <div class="success-message" id="success-message" style="display: none;">
            Appointment successfully added!
        </div>
        <div class="month-year" id="month-year"></div>
        <div id="calendar" class="calendar"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendar = document.getElementById('calendar');
            const monthYear = document.getElementById('month-year');
            const selectMonth = document.getElementById('selectMonth');
            const selectYear = document.getElementById('selectYear');
            const today = new Date();
            let currentMonth = today.getMonth();
            let currentYear = today.getFullYear();
            const currentDate = today.getDate();

            const appointments = <?php echo json_encode($appointments); ?>;

            // Populate month dropdown
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            months.forEach((month, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = month;
                selectMonth.appendChild(option);
            });

            // Populate year dropdown
            const years = [];
            const currentYearNum = today.getFullYear();
            for (let i = currentYearNum - 10; i <= currentYearNum + 10; i++) {
                years.push(i);
            }
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                selectYear.appendChild(option);
            });

            function generateCalendar(month, year) {
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                calendar.innerHTML = '';
                monthYear.textContent = `${months[month]} ${year}`;

                // Create weekday headers
                const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                weekdays.forEach(weekday => {
                    const weekdayElement = document.createElement('div');
                    weekdayElement.classList.add('weekday');
                    weekdayElement.textContent = weekday;
                    calendar.appendChild(weekdayElement);
                });

                // Adjust the first day of the month
                const firstDayOfMonth = new Date(year, month, 1).getDay();
                for (let i = 0; i < firstDayOfMonth; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.classList.add('calendar-day');
                    calendar.appendChild(emptyDay);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day');
                    if (day === currentDate && month === currentMonth && year === currentYear) {
                        dayElement.classList.add('today');
                    }
                    dayElement.textContent = day;

                    if (appointments[dateString]) {
                        const appointmentsElement = document.createElement('div');
                        appointmentsElement.classList.add('appointments');
                        appointments[dateString].forEach(appointment => {
                            const appointmentItem = document.createElement('div');
                            appointmentItem.innerHTML = `<strong>Title:</strong> ${appointment.title}<br>
                                                         <strong>Lawyer:</strong> ${appointment.lawyer_name}<br>
                                                         <strong>Description:</strong> ${appointment.description}`;
                            appointmentsElement.appendChild(appointmentItem);
                        });
                        dayElement.appendChild(appointmentsElement);
                        dayElement.classList.add('has-appointment');
                    }

                    calendar.appendChild(dayElement);
                }
            }

            function updateCalendar() {
                currentMonth = parseInt(selectMonth.value);
                currentYear = parseInt(selectYear.value);
                generateCalendar(currentMonth, currentYear);
            }

            // Set current month and year in dropdowns
            selectMonth.value = currentMonth;
            selectYear.value = currentYear;

            // Call updateCalendar when the page loads
            updateCalendar();

            // Event listener for dropdown change
            selectMonth.addEventListener('change', updateCalendar);
            selectYear.addEventListener('change', updateCalendar);
        });
    </script>
</body>
</html>

<?php
include("../auth/footer.php");
ob_end_flush(); // Send the output to the browser
?>
