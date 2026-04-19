<?php
include('../config.php');

// Initialize response array
$response = [
    'status' => 'error',
    'message' => ''
];

// Check connection
if (!$connect) {
    $response['message'] = 'Database connection failed';
    echo json_encode($response);
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $response['message'] = 'Missing required fields';
        echo json_encode($response);
        exit();
    }

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $date_submitted = date('Y-m-d H:i:s');

    // Prepare SQL statement
    $sql = "INSERT INTO contact_messages (name, email, subject, message, date_submitted) 
            VALUES (?, ?, ?, ?, ?)";
    
    // Create prepared statement
    $stmt = $connect->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $connect->error);
        $response['message'] = 'Database error occurred';
        echo json_encode($response);
        exit();
    }
    
    // Bind parameters
    $stmt->bind_param("sssss", $name, $email, $subject, $message, $date_submitted);
    
    // Execute statement
    if ($stmt->execute()) {
        // Optional: Send email notification
        $to = "support@golden-assets.gold";
        $email_subject = "New Contact Form Submission: " . htmlspecialchars($subject);
        $email_body = "You have received a new message.\n\n".
            "Name: " . htmlspecialchars($name) . "\n".
            "Email: " . htmlspecialchars($email) . "\n".
            "Subject: " . htmlspecialchars($subject) . "\n".
            "Message:\n" . htmlspecialchars($message);
        
        if (!mail($to, $email_subject, $email_body)) {
            error_log("Email failed to send");
            // Continue processing as email is optional
        }
        
        $stmt->close();
        $response['status'] = 'success';
        $response['message'] = 'Message sent successfully';
    } else {
        $stmt->close();
        error_log("Execute failed: " . $stmt->error);
        $response['message'] = 'Failed to save message';
    }
}

// Close connection is handled in config.php

// Return JSON response
echo json_encode($response);
?>