<?php
include('../config.php');

if (!isset($_GET['id'])) {
    header("Location: dashboard.php?page=users&error=No user specified");
    exit();
}

$user_id = $_GET['id'];

$sql = "DELETE FROM customer WHERE Customer_ID = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: dashboard.php?page=users&message=User deleted successfully");
} else {
    header("Location: dashboard.php?page=users&error=Error deleting user: " . $connect->error);
}
exit();