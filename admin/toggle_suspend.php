<?php
include('../config.php');

if (!isset($_GET['id'])) {
    header("Location: dashboard.php?page=users&error=No user specified");
    exit();
}

$user_id = $_GET['id'];

$sql = "UPDATE customer SET is_suspended = 1 - is_suspended WHERE Customer_ID = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: dashboard.php?page=users&message=User suspension status toggled");
} else {
    header("Location: dashboard.php?page=users&error=Error toggling user suspension: " . $connect->error);
}
exit();