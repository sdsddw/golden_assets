<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log file
$logFile = 'run.log';

// Function to log messages
function logMessage($message) {
    global $logFile;
    $logMessage = date('Y-m-d H:i:s') . " - " . $message . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Log script start
logMessage("Script started.");

// Check if config.php exists
if (!file_exists('config.php')) {
    logMessage("Error: config.php not found.");
    exit;
}

// Include config.php
require 'config.php';

// Log database connection attempt
logMessage("Attempting to connect to the database.");

// Check database connection
if (!$connect) {
    logMessage("Error: Database connection failed.");
    exit;
}

// Log successful database connection
logMessage("Database connection successful.");

// Query to retrieve users with investments of 3 days or less
$query = "
    SELECT 
        ui.user_id, 
        c.Email, 
        ui.plan_type, 
        ui.start_date, 
        i.duration 
    FROM 
        user_investments ui
    JOIN 
        customer c ON c.Customer_ID = ui.user_id
    JOIN 
        investments i ON i.investment_type = ui.plan_type
    WHERE 
        ui.start_date >= NOW() - INTERVAL 3 DAY
        AND i.duration <= 3"; // Assuming duration is in days

// Prepare the query
logMessage("Preparing SQL query.");
$stmt = $connect->prepare($query);

if (!$stmt) {
    logMessage("Error: Failed to prepare SQL query. Error: " . $connect->error);
    exit;
}

// Execute the query
logMessage("Executing SQL query.");
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if any investments were found
if ($result->num_rows > 0) {
    logMessage("Investments found. Processing notifications.");

    while ($row = $result->fetch_assoc()) {
        $userId = $row['user_id'];
        $email = $row['Email'];
        // $email = "brownlucky386@mail.com"; // Replace with dynamic email if needed

        $investmentType = $row['plan_type'];
        $duration = $row['duration'];

        // Prepare email content
        $subject = "Investment Reminder: {$investmentType}";
        $headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: Golden Assets <noreply@golden-assets.gold>";
// $message = "Dear User,\n\n".
        //            "This is a reminder that your investment in {$investmentType} is nearing its end.\n".
        //            "Duration: {$duration} days.\n".
        //            "Please take the necessary actions.\n\n".
        //            "Best Regards,\nYour Investment Team";
        $message = "<html>
     <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
            <div style='text-align: center; margin-bottom: 20px;'>
                <img src='https://golden-assets.gold/images/Logo.png' alt='Golden Assets Logo' style='max-width: 20%; height: auto;'>
            </div>
            <p style='color: #666; text-align: left;'>Dear User,</p><br>
            <p style='color: #666; text-align: left;'>This is a reminder that your investment in {$investmentType} is nearing its end</p><br>
            <p style='color: #666; text-align: left;'>Duration: {$duration} days,</p><br>
            <p style='color: #666; text-align: left;'>Thank you for investing with us,</p><br>
            <p style='color: #666; text-align: center;'>Best Regards,</p><br>
            <p style='color: #666; font-size: 12px; text-align: center;'>Golden Assets Company</p>
        </div>
      </body>
     </html>";

        // Log email attempt
        logMessage("Attempting to send email to: {$email}");

        // Send email
        if (mail($email, $subject, $message)) {
            logMessage("Email sent successfully to: {$email}");
        } else {
            logMessage("Error: Email failed to send to: {$email}");
        }
    }
} else {
    logMessage("No investments found for notifications.");
}

// Close the statement and connection
logMessage("Closing database connection.");
$stmt->close();
$connect->close();

// Log script end
logMessage("Script finished.");
?>