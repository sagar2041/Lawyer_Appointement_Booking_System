<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            background-color: #28a745;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
        }
        .checkmark {
            font-size: 100px;
            margin-bottom: 20px;
        }
        .message {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: #28a745;
            background-color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .button:hover {
            background-color: #218838;
            color: white;
        }
    </style>
</head>
<body>
        <link rel="stylesheet" href="..\popup_style.css">
        <div class="popup popup--icon -success js_success-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                Success 
            </h3>
            <p> Case registered</p>
            <p>
                <a href="..\bookings.php"><button class="button button--success" data-for="js_success-popup">Ok</button></a> 
                <?php echo "<script>setTimeout(\"location.href = '../bookings.php';\",1500);</script>"; ?>
            </p>
        </div>
        </div>
    <!-- <div class="container">
        <div class="checkmark">✔</div>
        <div class="message">Payment Successful</div>
        <a href="..\dashboard.php" class="button">Go to Dashboard</a>
    </div> -->
</body>
</html>
