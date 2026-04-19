<?php
include('../config.php');
$sessionUserId = $_SESSION['customer_id'] ?? 1;

function getUserDirectReferrals($connect, $userId) {
    $query = "SELECT r.referred_user_id, c.Customer_Name, c.created_at
              FROM referrals r
              JOIN customer c ON r.referred_user_id = c.Customer_ID
              WHERE r.user_id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $referrals = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $referrals[] = [
            'id' => $row['referred_user_id'],
            'name' => $row['Customer_Name'],
            'date' => $row['created_at'],
            'children' => []
        ];
    }
    mysqli_stmt_close($stmt);
    return $referrals;
}

function buildReferralTree($connect, $userId) {
    $referrals = getUserDirectReferrals($connect, $userId);
    
    foreach ($referrals as &$referral) {
        $referral['children'] = buildReferralTree($connect, $referral['id']);
    }
    
    return $referrals;
}

function getReferralTree($connect, $userId) {
    return buildReferralTree($connect, $userId);
}

function getTotalReferrals($connect, $userId) {
    $referralTree = getReferralTree($connect, $userId);
    return count($referralTree);
}
?>