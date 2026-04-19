<?php
// Include the database configuration
require '../config.php';

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

function renderReferralTree($tree) {
    $html = '<ul class="tree">';
    foreach ($tree as $node) {
        $html .= renderNode($node);
    }
    $html .= '</ul>';
    return $html;
}

function renderNode($node) {
    $html = '<li>';
    $html .= '<div class="node">';
    $html .= '<p class="name">Name: ' . htmlspecialchars($node['name']) . '</p>';
    $html .= '<p class="date">Date: ' . htmlspecialchars($node['date']) . '</p>';
    $html .= '</div>';
    
    if (!empty($node['children'])) {
        $html .= '<ul>';
        foreach ($node['children'] as $child) {
            $html .= renderNode($child);
        }
        $html .= '</ul>';
    }
    
    $html .= '</li>';
    return $html;
}

// Get the current user's Customer_ID
$sessionUserId = $_SESSION['user_id'] ?? 1; // Fallback to 1 if not set, for testing
$query = "SELECT Customer_ID FROM customer WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $sessionUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$currentUserId = $row['Customer_ID'] ?? null;

if (!$currentUserId) {
    die("Failed to retrieve Customer_ID for the current user");
}

// Get user's referral tree
$referralTree = getReferralTree($connect, $currentUserId);
$totalReferrals = count($referralTree);

// Get or generate referral link
$referralLink = "https://yourwebsite.com/register?ref=" . $currentUserId; // Adjust this to your actual referral link structure

?>

<div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">My Referral Network</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-gray-100 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Total Direct Referrals</h4>
            <p class="text-3xl font-bold text-indigo-600"><?php echo $totalReferrals; ?></p>
        </div>
        <div class="bg-gray-100 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Your Referral Link</h4>
            <div class="flex items-center mt-2">
                <input type="text" id="referralLink" value="<?php echo $referralLink; ?>" readonly class="flex-grow text-sm text-gray-600 bg-white border border-gray-300 rounded-l-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <button onclick="copyReferralLink()" class="bg-indigo-600 text-white px-3 py-2 rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Copy
                </button>
            </div>
        </div>
    </div>

    <h4 class="text-xl font-bold text-gray-800 mb-4">My Referral Tree</h4>
    <?php if ($totalReferrals == 0): ?>
        <p class="text-gray-500">You don't have any referrals yet. Share your referral link to start growing your network!</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <?php echo renderReferralTree($referralTree); ?>
        </div>
    <?php endif; ?>
</div>

<style>
.tree, .tree ul {
    list-style-type: none;
    padding-left: 20px;
}
.tree li {
    position: relative;
    padding-left: 20px;
}
.tree li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    border-left: 1px solid #ccc;
    height: 100%;
}
.tree li:last-child::before {
    height: 50%;
}
.tree li::after {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 20px;
    border-top: 1px solid #ccc;
}
.node {
    display: inline-block;
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 5px;
}
</style>

<script>
function copyReferralLink() {
    var copyText = document.getElementById("referralLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    
    // Create and show a toast notification
    var toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg transition-opacity duration-300';
    toast.textContent = 'Referral link copied!';
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>
