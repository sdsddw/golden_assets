<?php

require_once '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../sign_in.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
    $action = $_POST['action'];

    $query = "SELECT * FROM pending_transactions WHERE id = '$transaction_id'";
    $result = mysqli_query($connect, $query);
    $transaction = mysqli_fetch_assoc($result);

    $querytype = "SELECT * FROM pending_transactions WHERE id = '$transaction_id'";
    $checktype = mysqli_query($connect, $querytype);
    $transactionType = mysqli_fetch_assoc($checktype);
    $transaction_correct = $transactionType['transaction_type'];

    if ($transaction) {
        $customer_id = $transaction['customer_id'];
        $amount = $transaction['amount'];

        if ($action === 'approve') {
            if ($transaction_correct == "deposit") {
                // Update the user's balance
                $query1 = "SELECT Balance FROM customer WHERE Customer_ID = '$customer_id'";
                $result1 = mysqli_query($connect, $query1);
                $row = mysqli_fetch_assoc($result1);
                $databaseBalance = $row['Balance'];
                $newBalance = $amount + $databaseBalance;

                $updateBalance = "UPDATE customer SET Balance = '$newBalance' WHERE Customer_ID = '$customer_id'";
                mysqli_query($connect, $updateBalance);

                // Update the transaction status
                $updateTransaction = "UPDATE pending_transactions SET status = 'approved' WHERE id = '$transaction_id'";
                mysqli_query($connect, $updateTransaction);

                $updateHistory = "UPDATE transaction_history SET status = 'success' WHERE id = '$transaction_id'";
                mysqli_query($connect, $updateHistory);

                $_SESSION['balance'] = $newBalance;
                $response = array("message" => 'Transaction approved and balance updated.', "newBalance" => $newBalance);
            }else{
                $query1 = "SELECT Balance FROM customer WHERE Customer_ID = '$customer_id'";
                $result1 = mysqli_query($connect, $query1);
                $row = mysqli_fetch_assoc($result1);
                $databaseBalance = $row['Balance'];
                $newBalance = $databaseBalance - $amount;
                $updateBalance = "UPDATE customer SET Balance = '$newBalance' WHERE Customer_ID = '$customer_id'";
                mysqli_query($connect, $updateBalance);
                $updateTransaction = "UPDATE pending_transactions SET status = 'approved' WHERE id = '$transaction_id'";
                mysqli_query($connect, $updateTransaction);

                $updateHistory = "UPDATE transaction_history SET status = 'success' WHERE id = '$transaction_id'";
                mysqli_query($connect, $updateHistory);

                $_SESSION['balance'] = $newBalance;
                $response = array("message" => 'Transaction approved and balance updated.', "newBalance" => $newBalance);
            }
        } else {
            // Reject the transaction
            $updateTransaction = "UPDATE pending_transactions SET status = 'rejected' WHERE id = '$transaction_id'";
            mysqli_query($connect, $updateTransaction);

            $response = array("message" => 'Transaction rejected.');
        }
    } else {
        $response = array("message" => 'Transaction not found.');
    }

    mysqli_close($connect);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>