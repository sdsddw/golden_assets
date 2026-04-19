<?php
include('../config.php');

$sql = "SELECT * FROM customer";
$result = $connect->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="text-2xl font-bold mb-4">User Management</h2>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($users as $user): ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['Customer_ID']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['Customer_Name']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['Email']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($user['Balance'], 2); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="edit_user.php?id=<?php echo $user['Customer_ID']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['Customer_ID']; ?>" class="text-red-600 hover:text-red-900 mr-2" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    <a href="toggle_suspend.php?id=<?php echo $user['Customer_ID']; ?>" class="text-yellow-600 hover:text-yellow-900">
                        <?php echo $user['is_suspended'] ? 'Unsuspend' : 'Suspend'; ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>