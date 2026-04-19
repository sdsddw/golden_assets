<?php
session_start();
include('../config.php');

if (!isset($_SESSION['customer_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$page = $_GET['page'];
$limit = $_GET['limit'];
$offset = ($page - 1) * $limit;

$sql = "SELECT 'deposit' AS type, d.amount, d.currency, d.status, d.created_at AS date
        FROM deposits d
        WHERE d.user_id = ?
        UNION ALL
        SELECT 'withdrawal' AS type, w.amount, w.currency, w.status, w.created_at AS date
        FROM withdrawals w
        WHERE w.customer_id = ?
        ORDER BY date DESC
        LIMIT ? OFFSET ?";

$stmt = $connect->prepare($sql);
$stmt->bind_param("ssii", $_SESSION['customer_id'], $_SESSION['customer_id'], $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
$transactions = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($transactions);

$connect->close();
