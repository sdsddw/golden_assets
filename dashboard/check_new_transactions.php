<?php
session_start();
include('../config.php');

if (!isset($_SESSION['customer_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$sql = "SELECT 'deposit' AS type, d.amount, d.currency, d.status, d.created_at AS date
        FROM deposits d
        WHERE d.user_id = ? AND d.created_at > ?
        UNION ALL
        SELECT 'withdrawal' AS type, w.amount, w.currency, w.status, w.created_at AS date
        FROM withdrawals w
        WHERE w.customer_id = ? AND w.created_at > ?
        ORDER BY date DESC";

$stmt = $connect->prepare($sql);
$lastCheck = $_SESSION['last_transaction_check'] ?? date('Y-m-d H:i:s', strtotime('-30 seconds'));
$stmt->bind_param("ssss", $_SESSION['customer_id'], $lastCheck, $_SESSION['customer_id'], $lastCheck);
$stmt->execute();
$result = $stmt->get_result();
$newTransactions = $result->fetch_all(MYSQLI_ASSOC);

$_SESSION['last_transaction_check'] = date('Y-m-d H:i:s');

echo json_encode($newTransactions);

$connect->close();
