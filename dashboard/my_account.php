<?php
include('../config.php');

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch current user details
$user_id = $_SESSION['customer_id'];
$query = "SELECT Customer_Name, Email, Phone_Number FROM customer WHERE Customer_ID = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $customerName, $email, $phoneNumber);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Initialize a variable to hold the update status
$updateStatus = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_personal'])) {
        // Handle personal info update
        $newUsername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $newEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $newPhoneNumber = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);

        // Validate email
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $updateStatus = 'Invalid email format.';
        } else {
            $updateQuery = "UPDATE customer SET Customer_Name = ?, Email = ?, Phone_Number = ? WHERE Customer_ID = ?";
            $stmt = mysqli_prepare($connect, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ssss", $newUsername, $newEmail, $newPhoneNumber, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                $updateStatus = 'Personal information updated successfully.';
            } else {
                $updateStatus = 'Error updating personal information.';
            }
            mysqli_stmt_close($stmt);
        }
    }

    if (isset($_POST['update_password'])) {
        // Handle password update
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        // Verify current password
        $query = "SELECT Password FROM customer WHERE Customer_ID = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashedPassword);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (password_verify($currentPassword, $hashedPassword)) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE customer SET Password = ? WHERE Customer_ID = ?";
            $stmt = mysqli_prepare($connect, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ss", $hashedNewPassword, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                $updateStatus = 'Password updated successfully.';
            } else {
                $updateStatus = 'Error updating password.';
            }
            mysqli_stmt_close($stmt);
        } else {
            $updateStatus = 'Current password is incorrect.';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <title>Edit Account</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl mb-4">Edit Account Details</h2>
        <form method="POST" action="">
            <!-- Personal Information Section -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
                
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($customerName); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <div class="mt-1 relative">
                        <input type="tel" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($phoneNumber); ?>" class="block w-full border border-gray-300 rounded-md shadow-sm p-2 ">
                    </div>
                </div>
                
                <button type="submit" name="update_personal" class="bg-blue-500 text-white px-4 py-2 rounded">Update Personal Info</button>
            </div>

            <!-- Password Section -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Change Password</h3>
                
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <button type="submit" name="update_password" class="bg-green-500 text-white px-4 py-2 rounded">Change Password</button>
            </div>
        </form>

        <!-- Hidden input to store update status -->
        <input type="hidden" id="updateStatus" value="<?php echo htmlspecialchars($updateStatus); ?>">
    </div>

    <script>
  
        window.onload = function() {
            const updateStatus = document.getElementById('updateStatus').value;
            if (updateStatus) {
                alert(updateStatus); // Show alert with the update status
                window.location.href = window.location.href; // Refresh the page
               
            }
        };

        const phoneInput = document.querySelector("#phone_number");
        const iti = window.intlTelInput(phoneInput, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            preferredCountries: ['us', 'gb', 'ng', 'ke'],
            separateDialCode: true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json/")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            }
        });

        // Adjust the input width to account for the country code
        phoneInput.style.width = '100%';
        phoneInput.style.paddingLeft = '80px'; // Adjust this value as needed

        // Before form submission, format the phone number
        document.querySelector('form').addEventListener('submit', function(e) {
            const phoneNumber = iti.getNumber();
            document.querySelector("#phone_number").value = phoneNumber;
        });
    </script>
</body>
</html>
