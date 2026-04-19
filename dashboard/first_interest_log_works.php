<?php
require '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "No current investments.";
    exit;
}

$user_id = $_SESSION['customer_id'];

// Query to retrieve investment data for the current user along with customer details
$query = "
    SELECT 
        ui.plan_type, 
        ui.daily_roi, 
        ui.total_roi, 
        ui.start_date, 
        ui.end_date, 
        ui.user_id, 
        ui.amount,
        c.Balance, 
        i.duration -- Replace with the actual column(s) you want from the investments table
    FROM 
        user_investments ui
    JOIN 
        customer c ON c.Customer_ID = ui.user_id
    JOIN 
        investments i ON i.investment_type = ui.plan_type -- Join with investments table
    WHERE 
        ui.user_id = ? AND ui.status = 'active'"; // Assuming $user_id is the customer_id and adding ui.status = 'active'

$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$investments = array();

// Fetch all investment data and store in an array
while ($row = mysqli_fetch_assoc($result)) {
    // Extract data from the row
    $investment_type = $row['plan_type'];
    $daily_roi = $row['daily_roi'];
    $total_roi = $row['total_roi'];
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $amount = $row['amount'];
    $duration = $row['duration'];

    // Calculate next_payment
    $next_payment = date('Y-m-d H:i:s', strtotime($start_date) + ($duration * 86400)); // Assuming duration is in days

    // Store the data in an associative array
    $investment = array(
        'plan_type' => $investment_type,
        'daily_roi' => $daily_roi,
        'total_roi' => $total_roi,
        'start_date' => $start_date,
        'amount' => $amount,
        'duration' => $duration,
        'next_payment' => $next_payment
    );

    // Add the investment to the investments array
    $investments[] = $investment;
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Log</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .interest-log {
            background-color: #3b82f6; /* Lighter blue */
            border-radius: 10px;
            padding: 20px;
            color: white;
            max-width: 1200px;
            margin: 0 auto;
        }
        .interest-log h1 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        .log-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        .log-row {
            background-color: #60a5fa; /* Lighter blue */
            border-radius: 10px;
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }
        .log-row:hover {
            background-color: #3b82f6; /* Lighter blue */
        }
        .log-cell {
            padding: 15px;
        }
        .log-header {
            font-weight: bold;
            text-align: left;
            padding: 10px 15px;
        }
        .status-running {
            background-color: #f59e0b; /* Orange */
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            display: flex;
            align-items: center; /* Align items vertically */
        }
        .status-complete {
            background-color: #00ffff; /* Cyan */
            color: black;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            display: none; /* Hidden by default */
        }
        .capital-back {
            background-color: #00ff00; /* Green */
            color: black;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }
        .separator {
            border-top: 1px solid rgba(255, 255, 255, 0.5); /* Light separator line */
            margin: 10px 0; /* Space around the separator */
        }
        @media (max-width: 768px) {
            .interest-log {
                padding: auto;
                background-color: #2563eb; /* Darker blue */
            }
            .log-table, .log-row, .log-cell {
                display: block;
            }
            .log-row {
                margin-bottom: 10px;
                padding: 15px;
                background-color: #3b82f6; /* Lighter blue */
            }
            .log-header {
                display: none;
            }
            .log-cell {
                padding: 5px 0;
                text-align: left;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .log-cell:before {
                content: attr(data-label);
                font-weight: bold;
                padding-right: 10px;
            }
            .log-value {
                text-align: right;
            }
            .capital-back, .status-running {
                margin-left: auto;
            }
        }
    </style>
</head>
<body>
    <div class="interest-log">
        <h1>Interest Log</h1>
        <table class="log-table">
            <thead>
                <tr>
                    <th class="log-header">Plan Name</th>
                    <th class="log-header">Payable Interest</th>
                    <th class="log-header">Period</th>
                    <th class="log-header">Daily Profit</th>
                    <th class="log-header">Received</th>
                    <th class="log-header">Capital Back</th>
                    <th class="log-header">Invest Amount</th>
                    <th class="log-header">Status</th>
                    <th class="log-header">Next Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($investments)) {
                    foreach ($investments as $investment) {
                        echo "<tr class='log-row'>
                                <td class='log-cell' data-label='Plan Name'>{$investment['plan_type']}</td>
                                <td class='log-cell' data-label='Payable Interest'>\${$investment['total_roi']}</td>
                                <td class='log-cell' data-label='Period'>{$investment['duration']} days</td>
                                <td class='log-cell' data-label='Daily Profit'>\${$investment['daily_roi']}</td>
                                <td class='log-cell' data-label='Received'>0 Times</td>
                                <td class='log-cell' data-label='Capital Back'><span class='capital-back'>Yes</span></td>
                                <td class='log-cell' data-label='Invest Amount'>\${$investment['amount']}</td>
                                <td class='log-cell' data-label='Status'>
                                    <p class='status-running'>
                                        <i class='fas fa-spinner fa-spin text-blue-500'></i>&nbsp; Running </p>
                                </td>
                                <td class='log-cell' data-label='Next Payment'><span class='nextPayment' data-next-payment='" . strtotime($investment['next_payment']) . "'>" . $investment['next_payment'] . "</span></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No current investments.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function updateNextPayments() {
            let nextPaymentSpans = document.querySelectorAll('.nextPayment');
            nextPaymentSpans.forEach(function(span) {
                let nextPaymentTime = span.getAttribute('data-next-payment');
                let currentTime = Math.floor(Date.now() / 1000);
                let timeRemaining = nextPaymentTime - currentTime;

                if (timeRemaining < 0) {
                    timeRemaining = 0;
                }

                let days = Math.floor(timeRemaining / 86400);
                let hours = Math.floor((timeRemaining % 86400) / 3600);
                let minutes = Math.floor((timeRemaining % 3600) / 60);
                let seconds = timeRemaining % 60;

                span.textContent = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
            });
        }

        setInterval(updateNextPayments, 1000);
    </script>
</body>
</html>