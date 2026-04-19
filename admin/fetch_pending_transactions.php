<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: ../sign_in.php");
  exit;
} 
$query = "SELECT * FROM pending_transactions WHERE status = 'pending'";
$result = mysqli_query($connect, $query);
$pendingTransactions = [];

while ($row = mysqli_fetch_assoc($result)) {
    $pendingTransactions[] = $row;
}

mysqli_close($connect);

header('Content-Type: application/json');
echo json_encode($pendingTransactions);
?>
