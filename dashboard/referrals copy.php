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
    $html = '<div class="referral-tree">';
    foreach ($tree as $node) {
        $html .= renderNode($node, 1);
    }
    $html .= '</div>';
    return $html;
}

function renderNode($node, $level) {
    $html = '<div class="node level-' . $level . '">';
    $html .= '<div class="node-content">';
    $html .= '<p class="level">Level: ' . $level . '</p>';
    $html .= '<p class="name">Name: ' . htmlspecialchars($node['name']) . '</p>';
    $html .= '<p class="date">Date: ' . htmlspecialchars($node['date']) . '</p>';
    $html .= '</div>';
    
    if (!empty($node['children'])) {
        $html .= '<button class="toggle-children" aria-expanded="false" onclick="toggleChildren(this)">';
        $html .= '<i class="fas fa-chevron-down"></i>';
        $html .= '</button>';
        $html .= '<div class="children" style="display: none;">'; // Hide children by default
        foreach ($node['children'] as $child) {
            $html .= renderNode($child, $level + 1);
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
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
        <?php echo renderReferralTree($referralTree); ?>
    <?php endif; ?>
</div>

<style>
.referral-tree {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.node {
    background-color: #f0f0f0;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.node-content {
    margin-bottom: 10px;
}

.level, .name, .date {
    margin: 5px 0;
}

.level {
    font-weight: bold;
    color: #4a5568;
}

.children {
    margin-left: 20px;
    padding-left: 15px;
    border-left: 2px solid #ccc;
}

@media (min-width: 1024px) {
    .referral-tree {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: flex-start;
    }

    .node.level-1 {
        flex: 0 0 calc(33.333% - 20px);
        max-width: calc(33.333% - 20px);
        margin-bottom: 20px;
    }
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

function toggleChildren(button) {
    var childrenContainer = button.nextElementSibling;
    var isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    if (isExpanded) {
        childrenContainer.style.display = 'none';
        button.setAttribute('aria-expanded', 'false');
        button.querySelector('i').classList.remove('fa-chevron-up');
        button.querySelector('i').classList.add('fa-chevron-down');
    } else {
        childrenContainer.style.display = 'block';
        button.setAttribute('aria-expanded', 'true');
        button.querySelector('i').classList.remove('fa-chevron-down');
        button.querySelector('i').classList.add('fa-chevron-up');
    }
}
</script>

<style>
/* ... existing styles ... */

.toggle-children {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    transition: transform 0.3s ease;
}

.toggle-children[aria-expanded="true"] {
    transform: rotate(180deg);
}

.children {
    transition: max-height 0.3s ease-out;
    overflow: hidden;
}
</style>
