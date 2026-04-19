<?php
// Include database configuration
require_once 'config.php';

// Define log file path
define('LOG_FILE', '/home/goldoejd/public_html/cron_job.log');

// Function to log messages
function logMessage($message)
{
    $logMessage = date('Y-m-d H:i:s') . " - " . $message . "\n";
    file_put_contents(LOG_FILE, $logMessage, FILE_APPEND);
}

// Start script execution log
logMessage("Script started.");

// Check database connection
if (!$connect) {
    logMessage("Error: Database connection failed.");
    exit;
}

// Start a transaction
if (!$connect->begin_transaction()) {
    logMessage("Error: Cannot start transaction - " . $connect->error);
    exit;
}

// SQL query to select active investments and join with customer table to get email
$query = "
    SELECT 
        ui.id AS investment_id,
        ui.user_id,
        ui.daily_roi,
        ui.duration,
        ui.received,
        c.Email
    FROM 
        user_investments ui
    JOIN 
        customer c ON c.Customer_ID = ui.user_id
    WHERE 
        ui.duration > 0
";

// Execute the query
$result = mysqli_query($connect, $query);

if (!$result) {
    logMessage("Error: Query execution failed - " . mysqli_error($connect));
    $connect->rollback();
    exit;
}

// Check if any investments found
if (mysqli_num_rows($result) > 0) {
    logMessage("Active investments found. Processing updates and sending emails.");

    while ($row = mysqli_fetch_assoc($result)) {
        $investment_id = $row['investment_id'];
        $user_id = $row['user_id'];
        $daily_roi = $row['daily_roi'];
        $duration = $row['duration'];
        $user_email = $row['Email'];
        $received = $row['received'];

        // Update customer's Interest_Balance
        $update_balance_query = "UPDATE customer SET Interest_Balance = Interest_Balance + $daily_roi WHERE Customer_ID = " . mysqli_real_escape_string($connect, $user_id);
        if (!mysqli_query($connect, $update_balance_query)) {
            logMessage("Error: Failed to update Interest_Balance for user $user_id - " . mysqli_error($connect));
            $connect->rollback();
            exit;
        }

        // Reduce the duration by 1
        $new_duration = $duration - 1;
        $update_duration_query = "UPDATE user_investments SET duration = $new_duration WHERE id = " . mysqli_real_escape_string($connect, $investment_id);
        if (!mysqli_query($connect, $update_duration_query)) {
            logMessage("Error: Failed to update duration for investment $investment_id - " . mysqli_error($connect));
            $connect->rollback();
            exit;
        }

        // If duration is now 0, mark investment as completed
        // if ($new_duration == 0) {
        //     $update_status_query = "UPDATE user_investments SET status = 'completed' WHERE id = " . mysqli_real_escape_string($connect, $investment_id);
        //     if (!mysqli_query($connect, $update_status_query)) {
        //         logMessage("Error: Failed to update status for investment $investment_id - " . mysqli_error($connect));
        //         $connect->rollback();
        //         exit;
        //     }
        // }
        // ... existing code ...
        $newReceived = $received + 1;
        $updateReceivedQuery = "UPDATE user_investments SET received = ? WHERE id = ?";
        $stmt = $connect->prepare($updateReceivedQuery);
        $stmt->bind_param("ii", $newReceived, $investment_id);

        if (!$stmt->execute()) {
            logMessage("Error: Failed to update received count for investment $investment_id - " . $stmt->error);
            $connect->rollback();
            exit;
        }

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $subject = "Daily ROI Added to Your Interest Balance";
        // $message = "Dear User,\n\nYour daily ROI of $daily_roi has been added to your interest balance.\n\nThank you for investing with us!\n\nBest regards,\nThe Golden Assets Team";
        $message = "<html>
       <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
            <div style='text-align: center; margin-bottom: 20px;'>
                <img src='https://golden-assets.gold/images/Logo.png' alt='Golden Assets Logo' style='max-width: 20%; height: auto;'>
            </div>
            <p style='color: #666; text-align: left;'>Dear User,</p><br>
            <p style='color: #666; text-align: left;'>Your daily ROI of $daily_roi has been added to your interest balance.</p><br>
            <p style='color: #666; text-align: left;'>Thank you for investing with us,</p><br>
            <p style='color: #666; text-align: center;'>Best Regards,</p><br>
            <p style='color: #666; font-size: 12px; text-align: center;'>Golden Assets Company</p>
        </div>
        </body>
      </html>";
      
        $headers .= "From: Golden Assets <noreply@golden-assets.gold>";


        if (mail($user_email, $subject, $message, $headers)) {
            logMessage("Email sent successfully to: $user_email");

            //CHECK FOR PEOPLE WITH 0 DURATION
            $query1 = "
    SELECT 
        ui.id AS investment_id,
        ui.user_id,
        ui.daily_roi,
        ui.duration,
        ui.amount,
        c.Email
    FROM 
        user_investments ui
    JOIN 
        customer c ON c.Customer_ID = ui.user_id
    WHERE 
        ui.duration = 0
        AND ui.status = 'active'
";

            // Execute the query
            $results = mysqli_query($connect, $query1);

            if (!$result) {
                logMessage("Error: Query execution failed - " . mysqli_error($connect));
                $connect->rollback();
                exit;
            }
            sleep(4);
            while ($rows = mysqli_fetch_assoc($results)) {
                $investment_ids = $rows['investment_id'];
                $user_ids = $rows['user_id'];
                $daily_rois = $rows['daily_roi'];
                $durations = $rows['duration'];
                $user_emails = $rows['Email'];
                $amount = $rows['amount'];
                $status = $rows['status'];

                $update_status_querys = "UPDATE user_investments SET status = 'completed' WHERE id = " . mysqli_real_escape_string($connect, $investment_ids);

                if (!mysqli_query($connect, $update_status_querys)) {
                    logMessage("Error: Failed to update status for investment $investment_id - " . mysqli_error($connect));
                    $connect->rollback();
                    exit;
                }
                // Send completion email
                $subject = "Investment of $amount Completed";
                $message = "Dear User,\n\nYour Total capital investment $amount has been added to your Interest Wallet.\n\nVisit your dashboard to see more: https://golden-assets.gold/dashboard\n\nThank you for investing with us!\n\nBest regards,\n\nThe Golden Assets Team";
                $headers = "From: Golden Assets <noreply@golden-assets.gold>";
                mail($user_emails, $subject, $message, $headers);
            }
        } else {
            logMessage("Error: Email failed to send to: $user_email");
        }

        logMessage("Processed investment $investment_id for user $user_id.");
    }
} else {
    logMessage("No active investments found.");
}

// Commit the transaction
$connect->commit();
logMessage("Transaction committed successfully.");

// Close database connection
mysqli_close($connect);

// End script execution log
logMessage("Script finished.");
