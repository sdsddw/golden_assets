<?php
require_once '../config.php';
session_start();


if (!isset($_SESSION['balance'])) {
    header("Location: ../sign_in.php");
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
$customer_id = $_SESSION['user_id'];
$query = "SELECT * FROM pending_transactions WHERE customer_id = '$customer_id' AND transaction_type = 'withdrawal'";
$result = mysqli_query($connect, $query);
$transaction_history = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transaction_history[] = $row;
}
}

mysqli_close($connect);
header('Content-Type: application/json');
echo json_encode($transaction_history);
?>
